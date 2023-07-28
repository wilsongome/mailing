<?php 
namespace App\Domain\ContactList;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Storage;

class ContactListFile{

    private $storage_path = '/app/';
    private $root_path = 'contact_lists';

    public function content(string $filePath)
    {
        $result = [];
        try{
            $path = storage_path( $this->storage_path. $filePath);
            $lines = array_map('str_getcsv', file($path));
            $headers = explode(";", $lines[0][0]);
            $i = -1;
            foreach($lines as $values){
                $i++;
                if($i == 0){
                    continue;
                }
                array_push( $result, array_combine( $headers, explode( ";", $values[0] ) ) );
            }
        }catch(Exception $e){
            Log::error($e);
            return $result;
        }
        return $result;
    }

    public function destroy(string $filePath) : bool
    {
        try{
            return Storage::delete($filePath);
        }catch(Exception $e){
            Log::error($e);
        }  
        return false;
    }

    public function download(string $filePath, string $fileName)
    {
        try{
            $file = storage_path( $this->storage_path. $filePath);
            $headers = array('Content-Type: application/csv');
            return FacadesResponse::download($file,  $fileName, $headers);
        }catch(Exception $e){
            Log::error($e);
        }  
    }

    public function store(UploadedFile $file) : array
    {
        $result = ['fileName' => null, 'filePath' => null];
        try{
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = time().'.'.$extension;
            //Save to disc
            $filePath = $file->storeAs($this->root_path, $fileNameToStore);
            $result = ['fileName' => $fileName, 'filePath' => $filePath];
        }catch(Exception $e){
            Log::error($e);
        }

        return $result;
}

}
?>