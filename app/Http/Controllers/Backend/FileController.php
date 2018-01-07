<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Posts\PostRepository;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class FileController
 *
 * @package App\Http\Controllers\Backend
 */
class FileController extends Controller
{
    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * FileController constructor.
     *
     * @param Filesystem $file
     * @param PostRepository $post
     */
    public function __construct(Filesystem $file, PostRepository $post)
    {
        $this->file = $file;
        $this->post = $post;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filesArray = [];
        $filesInFolder = $this->file->files('upload/covers');
        foreach ($filesInFolder as $file) {
            $path = pathinfo($file);

            if (! starts_with($path['filename'], 'thumbnail')) {
                $filesArray[] = $path;
            }
        }

        $files = collect($filesArray);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 32;
        $offSet = ($page * $perPage) - $perPage;
        $items = $files->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($files, count($files), $perPage);
        $links->setPath('/backend/files');

        $dirSize = $this->getDirectorySize('upload/covers');
        $files_count = $this->countFiles('upload/covers');

        $data = [
            'files' => $items,
            'links' => $links,
            'dir_size' => $dirSize,
            'count' => $files_count
        ];

        return view('backend.files.index', $data);
    }

    /**
     * @param $path
     * @return float
     */
    public function getDirectorySize($path): float
    {
        $total = 0;
        $files = $this->file->files($path);

        foreach ($files as $filepath) {
            $total += $this->file->size($filepath);
        }

        return round($total/1048576, 2);
    }

    /**
     * @param $path
     * @return int
     */
    public function countFiles($path): int
    {
        return count($this->file->files($path));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function openImage(Request $request): View
    {
        $path = $request->get('path');
        $file = pathinfo($path);
        $file['dirname'] = $request->get('dir');

        $post = $this->getAssociatedPost($file['basename']);

        $data = [
            'file' => $file,
            'post' => $post
        ];

        return view('backend.files.show', $data);
    }

    /**
     * @param $img
     * @return Post
     */
    public function getAssociatedPost($img): Post
    {
        return $this->post->getPostByImg($img);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $newFile = 'upload/covers/'.$request->get('title').'.jpg';
        $newFileThumbnail = 'upload/covers/'.'thumbnail_'.$request->get('title').'.jpg';
        $this->updatePost($request->get('old_title'), $request->get('title'));

        $move = $this->file->move('upload/covers/'.$request->get('old_title'), $newFile);
        $moveThumbnail = $this->file->move('upload/covers/'.'thumbnail_'.$request->get('old_title'), $newFileThumbnail);

        return redirect()->to('/backend/files');
    }

    /**
     * @param $img
     * @param $newImg
     */
    public function updatePost($img, $newImg): void
    {
        $post = $this->post->getPostByImg($img);
        $post->img = $newImg.'.jpg';
        $post->img_thumbnail = 'thumbnail_'.$newImg.'.jpg';
        $post->update();
    }

}
