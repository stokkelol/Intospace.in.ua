<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Filesystem\Filesystem;
use App\Support\Images\ImageSaver;
use Illuminate\Pagination\LengthAwarePaginator;

class FileController extends Controller
{
    protected $file;

    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }

    public function index(Request $request)
    {
        $filesArray = [];
        $filesInFolder = $this->file->files('upload/covers');
        foreach($filesInFolder as $file)
        {
            $path = pathinfo($file);
            if(! starts_with($path['filename'], 'thumbnail')) {
                $filesArray[] = $path;
            }
        }

        $files = collect($filesArray);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 16;
        $offSet = ($page * $perPage) - $perPage;
        $items = $files->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($files, count($files), $perPage);
        $links->setPath('/backend/files');

        $dirSize = $this->getDirectorySize('upload/covers');
        $files_count = $this->countFiles('upload/covers');

        $data = [
            'files' =>  $items,
            'links' =>  $links,
            'dir_size'  =>  $dirSize,
            'count'     =>  $files_count
        ];

        return view('backend.files.index', $data);
    }

    public function getDirectorySize($path)
    {
        $total = (int) 0;
        $files = $this->file->files($path);
        foreach($files as $filepath)
        {
            $total += $this->file->size($filepath);
        }

        return round($total/1048576, 3);
    }

    public function countFiles($path)
    {
        return count($this->file->files($path));
    }
}
