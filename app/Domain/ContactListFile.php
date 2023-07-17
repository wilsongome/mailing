<?php 
namespace App\Domain;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Storage;

class ContactListFile{

    private $path_root = 'contact_lists';

    public function destroy(string $filePath) : bool
    {
        try{
            return Storage::delete($filePath);
        }catch(Exception $e){
            Log::error($e);
            return false;
        }  
    }

    public function download(string $filePath, string $fileName)
    {
        $file= storage_path( "/app/". $filePath);
        $headers = array('Content-Type: application/csv');
        return FacadesResponse::download($file,  $fileName, $headers);
    }

    public function store(UploadedFile $file) : array
    {
        $result = ['fileName' => null, 'filePath' => null];
        try{
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = time().'.'.$extension;
            //Save to disc
            $filePath = $file->storeAs($this->path_root, $fileNameToStore);
            $result = ['fileName' => $fileName, 'filePath' => $filePath];
        }catch(Exception $e){
            Log::error($e);
        }

        return $result;
}

}
?>