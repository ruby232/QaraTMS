<div id="test_case_editor">

    <div class="d-flex justify-content-between border-bottom mt-2 pb-2 mb-2">
        <div>
            <span class="fs-5">{{__('Edit Test Case')}}</span>
        </div>

        <div>
            <button href="button" class="btn btn-danger btn-sm" onclick="renderTestCase({{$testCase->id}})">
                <i class="bi bi-x-lg"></i> <b>{{__('Cancel')}}</b>
            </button>
        </div>
    </div>

    <div id="test_case_content">
        <div class="p-4 pt-0">

            <div class="row mb-3">

                <div class="mb-3 d-flex justify-content-start border p-3 bg-light">

                    <div>
                        <label for="test_suite_id" class="form-label"><strong>{{__('Test Suite')}}</strong></label>
                        <select name="suite_id" id="tce_test_suite_select" class="form-select border-secondary">

                            @foreach($repository->suites as $repoTestSuite)
                                <option value="{{$repoTestSuite->id}}"
                                        @if($repoTestSuite->id == $testCase->suite_id)
                                            selected
                                        @endif
                                >
                                    {{$repoTestSuite->title}}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mx-4">
                        <label class="form-label">
                            <b>{{__('Priority')}}</b>
                            <i class="bi bi-chevron-double-up text-danger"></i>|<i class="bi bi-list text-info"></i>|<i
                                    class="bi bi-chevron-double-down text-warning"></i>
                        </label>

                        <select id="tce_priority_select" name="priority" class="form-select border-secondary">
                            <option value="{{\App\Enums\CasePriority::NORMAL}}"
                                    @if($testCase->priority == \App\Enums\CasePriority::NORMAL) selected @endif>
                                {{__('Normal')}}
                            </option>
                            <option value="{{\App\Enums\CasePriority::HIGH}}"
                                    @if($testCase->priority == \App\Enums\CasePriority::HIGH) selected @endif>
                                {{__('High')}}
                            </option>
                            <option value="{{\App\Enums\CasePriority::LOW}}"
                                    @if($testCase->priority == \App\Enums\CasePriority::LOW) selected @endif>
                                {{__('Low')}}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label"><b>{{__('Type')}}</b> <i class="bi bi-person"></i> | <i class="bi bi-robot"></i></label>
                        <select name="automated" class="form-select border-secondary" id="tce_automated_select" value="1">
                            <option value="0" @if($testCase->manual) selected @endif>{{__('Manual')}}</option>
                            <option value="1" @if($testCase->automated) selected @endif>{{__('Automated')}}</option>
                        </select>
                    </div>

                </div>

                <input type="hidden" id="tce_case_id" value="{{$testCase->id}}">

                <div class="mb-3 p-0 title-wrapper">
                    <label for="title" class="form-label"><b>{{__('Title')}}</b></label>
                    <input name="title" id="tce_title_input" type="text" class="form-control border-secondary"
                           autofocus required value="{{$testCase->title}}">
                    <div class="invalid-feedback">
                        {{__('Title is required')}}
                    </div>
                </div>

                <div class="col p-0">
                    <label class="form-label"><b>{{__('Preconditions')}}</b></label>
                    @if(isset($data->preconditions))
                        <textarea name="pre_conditions" class="editor_textarea form-control border-secondary"
                                  id="tce_preconditions_input" rows="3">{{ $data->preconditions }}</textarea>
                    @else
                        <textarea name="pre_conditions" class="editor_textarea form-control border-secondary"
                                  id="tce_preconditions_input" rows="3"></textarea>
                    @endif
                </div>

            </div>

            <div class="row" id="steps_container">
                <div class="p-0 mb-1">
                    <b class="fs-5">{{__('Steps')}}</b>
                    <span class="text-muted" style="font-size: 12px">{{__('Action')}} <i class="bi bi-arrow-right"></i> {{__('Expected Result')}}</span>
                </div>

                @if(isset($data->steps))

                    @foreach($data->steps as $id => $step)

                        <div class="row m-0 mt-2 p-0 step">
                            <div class="col-auto p-0 d-flex flex-column align-items-center">
                                <span class="fs-5 step_number">{{$id+1}}</span>

                                <button type="button" class="btn btn-outline btn-sm step_delete_btn px-1 py-0"
                                        onclick="stepUp(this)">
                                    <i class="bi bi-arrow-up-circle"></i>
                                </button>

                                <button type="button" class="btn btn-outline-danger btn-sm step_delete_btn px-1 py-0"
                                        onclick="removeStep(this)">
                                    <i class="bi bi-x-circle"></i>
                                </button>

                                <button type="button" class="btn btn-outline btn-sm step_delete_btn px-1 py-0"
                                        onclick="stepDown(this)">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button>
                            </div>

                            <div class="col p-0 px-1 test_case_step">
                                <textarea class="editor_textarea form-control border-secondary step_action" rows="2">
                                    @if(isset($step->action))
                                        {!! $step->action !!}
                                    @endif
                                </textarea>
                            </div>
                            <div class="col p-0 test_case_step">
                                <textarea class="editor_textarea form-control border-secondary step_result" rows="2">
                                    @if(isset($step->result))
                                        {!! $step->result !!}
                                    @endif
                                </textarea>
                            </div>
                        </div>
                    @endforeach

                @else

                    <div class="row m-0 p-0 step">
                        <div class="col-auto p-0 d-flex flex-column align-items-center">
                            <span class="fs-5 step_number">1</span>

                            <button type="button" class="btn btn-outline btn-sm step_delete_btn px-1 py-0"
                                    onclick="stepUp(this)">
                                <i class="bi bi-arrow-up-circle"></i>
                            </button>

                            <button type="button" class="btn btn-outline-danger btn-sm step_delete_btn px-1 py-0"
                                    onclick="removeStep(this)">
                                <i class="bi bi-x-circle"></i>
                            </button>

                            <button type="button" class="btn btn-outline btn-sm step_delete_btn px-1 py-0"
                                    onclick="stepDown(this)">
                                <i class="bi bi-arrow-down-circle"></i>
                            </button>
                        </div>

                        <div class="col p-0 px-1 test_case_step">
                            <textarea class="editor_textarea form-control border-secondary step_action"
                                      rows="2"></textarea>
                        </div>
                        <div class="col p-0 test_case_step">
                            <textarea class="editor_textarea form-control border-secondary step_result"
                                      rows="2"></textarea>
                        </div>
                    </div>

                @endif

            </div>

        </div>
    </div>

    <div id="test_case_editor_footer" class="col-5 d-flex justify-content-end border-top pt-2">

        <button type="button" class="btn btn-primary px-5" onclick="addStep()">
            <i class="bi bi-plus-circle"></i>
            {{__('Add Step')}}
        </button>

        <div class="col d-flex justify-content-end pe-3">
            <button id="tce_save_btn" type="button" class="btn btn-warning px-5 mx-3 me-3" onclick="updateTestCase()">
                <i class="bi bi-save"></i>
                {{__('Update Test Case')}}
            </button>
        </div>
    </div>

</div>




