<?php

namespace App\Http\Requests;

use App\Models\Complaint;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'complaint_by' => 'required',
            // 'complaint_name' => 'required',
            'complaint_title' => 'required',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email',
            'complaint_type' => 'required',
            'priority' => 'required',
            'attachment' => 'required|file|mimes:jpg,png,jpeg,pdf|max:500',
            // 'division' => 'required',
            'district' => 'required',
            // 'sub_division' => 'required',
            // 'block' => 'required',
            // 'society' => 'required',
            // 'description' => 'required',
            'forward_complaint_to' => 'required',
            'aadhar_upload' => 'required|file|mimes:jpg,png,jpeg,pdf|max:500',
        ];
    }


    public function messages(): array
    {
        return [
            'complaint_by' => 'Please Enter Complent by',
            // 'complaint_name.required' => 'Please enter Complaint Name',
            'complaint_title.required' => 'Please enter Complaint Title',
            'contact_number.required' => 'Please enter Contact Number',
            'contact_number.digits' => 'Contact Number Must be 10 Digits',
            'email.required' => 'Please enter Email Address',
            'email.email' => 'Please enter a Valid Email Address',
            'complaint_type.required' => 'Complaint Type Must be Required',
            'priority.required' => 'Priority Must be Required',
            'attachment.required' => 'Please Upload Attchment',
            'attachment.mimes' => 'Invalid File Format',
            // 'division.required' => 'Please Select Division',
            'district.required' => 'Please Select District',
            // 'sub_division.required' => 'Please Select Sub Division',
            // 'block.required' => 'Please Select Block',
            // 'society.required' => 'Please Select Society',
            // 'description.required' => 'Please enter Description',
            'forward_complaint_to.required' => 'Please Select Forward Complaint To',
            'aadhar_upload.required' => 'Please Upload Aadhar',
            'aadhar_upload.mimes' => 'Invalid File Format',
        ];
    }
}