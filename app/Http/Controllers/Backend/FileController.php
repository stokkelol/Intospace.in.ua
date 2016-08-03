<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Filesystem\Filesystem;
use App\Support\Images\ImageSaver;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Posts\PostRepository;

class FileController extends Controller
{
    protected $file;
    protected $post;

    public function __construct(Filesystem $file, PostRepository $post)
    {
        $this->file = $file;
        $this->post = $post;
    }

    public function index(Request $request)
    {
        $filesArray = [];
        $filesInFolder = $this->file->files('upload/covers');
        foreach ($filesInFolder as $file)
        {
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
            'files'     =>  $items,
            'links'     =>  $links,
            'dir_size'  =>  $dirSize,
            'count'     =>  $files_count
        ];

        return view('backend.files.index', $data);
    }

    public function getDirectorySize($path)
    {
        $total = (int) 0;
        $files = $this->file->files($path);
        foreach ($files as $filepath)
        {
            $total += $this->file->size($filepath);
        }

        return round($total/1048576, 2);
    }

    public function countFiles($path)
    {
        return count($this->file->files($path));
    }

    public function openImage(Request $request)
    {
        $path = $request->get('path');
        $file = pathinfo($path);
        $file['dirname'] = $request->get('dir');

        $post = $this->associateWithPost($file['basename']);

        $data = [
            'file'  =>  $file,
            'post'  =>  $post
        ];

        //dd($data);

        return view('backend.files.show', $data);
    }

    public function associateWithPost($imgPath)
    {
        return $this->post->getPostByImg($imgPath);
    }

    public function store(Request $request)
    {
        $newFile = 'upload/covers/'.$request->get('title').'.jpg';
        $move = $this->file->move($request->get('old_title'), $newFile);
        $post = $this->post->getPostByImg($request->get('path'));
    }

}
