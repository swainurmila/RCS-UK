<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class Helpers
{
    public static function fileUpload(Request $request, $inputName, $path, $docName, $oldDoc)
    {

        if (!file_exists($path)) {
            Storage::makeDirectory($path, 0777, true);
        }

        $file = '';

        if (!empty($oldDoc)) {

            $file = $oldDoc;
        }

        if ($request->hasFile($inputName)) {

            if (!empty($oldDoc)) {

                if (Storage::exists($path . $oldDoc)) {

                    Storage::delete($path . $oldDoc);
                }
            }

            $doc = $request->file($inputName);

            $ext = $doc->getClientOriginalExtension();
            $file_name = $docName . time() . uniqid(rand()) . '.' . $ext;

            if (Storage::put($path . $file_name, file_get_contents($doc))) {

                $file = $file_name;
            };
        }

        return $file;
    }
}
