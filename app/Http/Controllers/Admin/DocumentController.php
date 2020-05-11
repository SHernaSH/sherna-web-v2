<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class handling upload and delete of documents
 *
 * Class DocumentController
 * @package App\Http\Controllers\Admin
 */
class DocumentController extends Controller
{
    /**
     * Display a listing of all the documents
     *
     * @return View    index page listing all the documents
     */
    public function index()
    {
        $docs = File::allFiles(public_path('docs'));

        return view('admin.doc.index', ['docs' => $docs]);
    }

    /**
     * Upload the chosen file to the server side storage
     *
     * @param Request $request      request with the chosen file
     * @return RedirectResponse     return index view of all documents
     * @throws ValidationException
     */
    public function upload(Request $request)
    {
        $this->validate($request, ['file' => 'required']);

        if ($request->file('file')->isValid()) {
            $request->file->move(public_path('docs/'), $request->file->getClientOriginalName());
            flash()->success('File uploaded successfully.');
        } else {
            flash()->error('File upload was not successful');
        }

        return redirect()->route('document.index');
    }

    /**
     * Deletion of chosen document from server side storage
     *
     * @param string $path          path of the document that should be deleted
     * @return RedirectResponse     return index view of all documents
     */
    public function delete(string $path)
    {
        if(File::delete(public_path('docs/' . $path))) {
            flash()->success('File successfully deleted.');
            return redirect()->route('document.index');

        } else {
            flash()->error('File was not deleted.');
            return redirect()->route('document.index')->setStatusCode(304);

        }

    }
}
