<div class="row additionalMember">
    <!-- <legend class="w-auto px-2"></legend> -->
    <div class="mb-3 col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.name')}}</label>
        <input type="text" class="form-control col-md-4 form-control-sm" name="name[]"
            placeholder="{{__('messages.membername')}}" value="" onkeyup="validateData(this,'name0')" />
        <span id="name0" class="error error-name"></span>
    </div>
    <!-- Aadhaar No -->
    <div class="mb-3 col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.AadhaarNo')}}</label>
        <input type="text" onkeyup="validateData(this,'aadhar_no0')" class="form-control col-md-4 form-control-sm"
            name="aadhar_no[]" placeholder="{{__('messages.aadhaarno')}}" value="" onblur="checkAadhaarExist(this)" />
        <span id="aadhar_no0" class="error error-aadhar_no"></span>
    </div>
    <!-- Address -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.fulladdress')}}</label>
        <input type="text" onkeyup="validateData(this,'address0')" class="form-control col-md-4 form-control-sm"
            name="address[]" placeholder="{{__('messages.memberaddress')}}" value="" />
        <span id="address0" class="error error-address"></span>
    </div>
    <!-- Gender Field -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.gender')}}</label>
        <select onchange="validateData(this,'gender0')" class="form-select form-control col-md-4 form-control-sm" name="gender[]">
            <option value="">{{__('messages.select')}}
            </option>
            <option value="1">
                {{__('messages.male')}}
            </option>
            <option value="2">
                {{__('messages.female')}}
            </option>
            <option value="3">
                {{__('messages.transgender')}}
            </option>
        </select>
        <span id="gender0" class="error error-gender"></span>
    </div>
    <!-- Marital Status Field -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.ismarried')}}</label>
        <select onchange="validateData(this,'is_married0')" class="form-select form-control col-md-4 form-control-sm"
            name="is_married[]">
            <option value="">{{__('messages.select')}}
            </option>
            <option value="1">
                {{__('messages.yes')}}
            </option>
            <option value="2">
                {{__('messages.no')}}
            </option>
        </select>
        <span id="is_married0" class="error errord-is_married"></span>
    </div>
    <!-- Father/Spouse Name -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.FatherName')}}</label>
        <input type="text" onkeyup="validateData(this,'father_spouse_name0')"
            class="form-control col-md-4 form-control-sm" name="father_spouse_name[]"
            placeholder="{{__('messages.FatherName')}}" value="" />
        <span id="father_spouse_name0" class="error errord-father_spouse_name"></span>
    </div>
    <!-- Designation -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.designation')}}</label>
        <input type="text" onkeyup="validateData(this,'designation0')" class="form-control col-md-4 form-control-sm"
            name="designation[]" placeholder="{{__('messages.designation')}}" value="" />
        <span id="designation0" class="error errord-designation"></span>
    </div>
    <!-- Buisness -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.buisness')}}</label>
        <input type="text" class="form-control col-md-4 form-control-sm" name="buisness_name[]"
            placeholder="{{__('messages.buisnessname')}}" value="" />
    </div>
    <!-- Signature -->
    <div class="col-md-3 form-group">
        <label class="form-label fw-bold">{{__('messages.signature')}}</label>
        <input type="file" onkeyup="validateData(this,'signature0')" class="form-control col-md-4 form-control-sm"
            name="signature[]" accept="image/*,application/pdf" value="{{$members->signature ?? ''}}" />
        <span id="signature0" class="error error-signature"></span>
    </div>

</div>