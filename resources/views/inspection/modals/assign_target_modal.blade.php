<!-- resources/views/inspection/modals/assign_target_modal.blade.php -->
<div class="modal fade" id="assignTargetModal" tabindex="-1" aria-labelledby="assignTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form action="{{ route('assign-inspection-societies') }}" method="POST" id="assignTargetForm">
            @csrf
            <input type="hidden" name="parent_target_id" id="parent_target_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Societies to ARCS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">District</label>
                        <input type="text" class="form-control" id="modal_district_name" readonly>
                        <input type="hidden" name="dist_id" id="modal_district_id">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Block</label>
                        <select class="form-select" name="block_id" id="block_id" required>
                            <option value="">-- Select Block --</option>
                        </select>
                    </div>
                    @if ($roleId == '5')
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Designation</label>
                            <select class="form-select" name="designation_id" id="designation_id" required>
                                <option value="arcs">ARCS</option>
                            </select>
                        </div>
                    @else
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Designation</label>
                            <select class="form-select" name="designation_id" id="designation_id" required>
                                <option value="">--Select--</option>
                                <option value="adco">ADCO</option>
                                <option value="ado">ADO</option>
                                <option value="supervisor">supervisor</option>
                                <option value="arcs">ARCS</option>
                            </select>
                        </div>
                    @endif

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Assigned Officer</label>
                        <input type="text" class="form-control" id="assigned_officer_name" readonly required>
                        <input type="hidden" name="assigned_id" id="assigned_id">
                    </div>
                    @if ($roleId == '5')
                        <div class="mb-3 col-6">
                            <label class="form-label">Select Societies</label>
                            <select id="society_ids" name="society_ids[]" multiple="multiple" class="form-control"
                                style="width: 100%;">

                            </select>
                        </div>
                    @else
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Select Societies</label>
                            <div id="society_checkboxes" class="border rounded p-2"
                                style="max-height: 200px; overflow-y: auto;">
                                <!-- Checkboxes will be populated by JS -->
                            </div>
                        </div>
                    @endif


                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Assign</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
