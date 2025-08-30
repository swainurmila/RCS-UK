<?php

use Illuminate\Support\Facades\Auth;

/* if (!function_exists('complaint_app_role')) {
    function complaint_app_role()
    {
        return $complaintAuthType = Auth::user()->role_id;
        $complaintAuthRole = false;
        if ($complaintAuthType == ["3", "4", "5", "6"]) {
            $complaintAuthRole = true;
        }
        return $complaintAuthRole;
    }
} */

if (!function_exists('complaint_app_role')) {
    function complaint_app_role()
    {
        $complaintAuthType = Auth::user()->role_id;
        // dd([
        //     'role_id' => $complaintAuthType,
        //     'is_allowed' => in_array((string) $complaintAuthType, ["3", "4", "5", "6"]),
        // ]);

        $allowedRoles = ["3", "4", "5", "6", "11", "12", "13"];

        return in_array((string) $complaintAuthType, $allowedRoles);
    }
}


if (!function_exists('getComplaintDataByDistrict')) {
    function getComplaintDataByDistrict($districtName, $districtComplaints)
    {
        $districtData = $districtComplaints->firstWhere('district_name', $districtName);
        return [
            'total' => $districtData ? $districtData->total_complaints : 0,
            'resolved' => $districtData ? $districtData->resolved_complaints : 0,
        ];
    }
}