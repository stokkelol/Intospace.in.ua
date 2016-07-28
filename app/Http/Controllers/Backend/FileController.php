<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Filesystem\Filesystem;
use App\Support\Images\ImageSaver;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
            $filesArray[] = $path;
        }

        $files = collect($filesArray);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 28;
        $offSet = ($page * $perPage) - $perPage;
        $items = $files->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($files, count($files), $perPage);
        $links->setPath('/backend/files');

        $data = [
            'files' =>  $items,
            'links' =>  $links
        ];

        return view('backend.files.index', $data);
    }
}
