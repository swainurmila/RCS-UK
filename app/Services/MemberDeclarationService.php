<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Members;
use Illuminate\Http\Request;

class MemberDeclarationService
{
    public function storeMembers(Request $request, array $member_input_data, $member_declarationId): array
    {
        $member_id_arr = [];

        foreach ($member_input_data['name'] as $index => $name) {
            $member_data = [
                'member_declaration_id' => $member_declarationId,
                'society_id' => $member_input_data['society_id'],
                'name' => $name,
                'address' => $member_input_data['address'][$index],
                'gender' => $member_input_data['gender'][$index],
                'is_married' => $member_input_data['is_married'][$index],
                'father_spouse_name' => $member_input_data['father_spouse_name'][$index],
                'designation' => $member_input_data['designation'][$index],
                'buisness_name' => $member_input_data['buisness_name'][$index],
            ];

            // File fields and their upload paths
            $file_fields = [
                'aadhar_no' => 'uploads/aadhaar/',
                'signature' => 'uploads/signatures/',
                'membership_form' => 'uploads/membership_forms/',
                'declaration1' => 'uploads/declarations/',
                'declaration2' => 'uploads/declarations/',
            ];

            foreach ($file_fields as $field => $uploadPath) {
                if ($request->hasFile($field) && isset($request->file($field)[$index])) {
                    $file = $request->file($field)[$index];
                    $path = $uploadPath . $file->hashName();
                    Storage::disk('public')->put($path, file_get_contents($file));
                    $member_data[$field] = $path;
                }
            }

            // Create or update member
            $member_upd = Members::updateOrCreate(
                ['id' => $member_input_data['member_id'][$index] ?? null],
                $member_data
            );

            $member_id_arr[$index] = $member_upd->id;
        }

        return $member_id_arr;
    }
}
