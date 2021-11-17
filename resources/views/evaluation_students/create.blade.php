<form action="{{ route('evaluation_students.store') }}" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" name="evaluation_faculty" value="{{ $evaluation_faculty->id }}">
    <div class="modal fade" id="createEvaluationStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluate</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <img src="{{ asset($evaluation_faculty->faculty->avatar()) }}" alt="" class="img-thumbnail">
                            </div>
                            <div class="form-group">
                                <label>Faculty:</label>
                                {{ $evaluation_faculty->faculty->getFacultyName() }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            @foreach ($questions as $index => $question)
                            <div class="form-group">
                                <p>{{ ($index+1) . ". " . $question->question }}</p>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly agree" id="stronglyAgree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="stronglyAgree-{{ $question->id }}">Strongly Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="agree" id="agree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="agree-{{ $question->id }}">Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="disagree" id="disagree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="disagree-{{ $question->id }}">Disgree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly disagree" id="stronglyDisagree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="stronglyDisagree-{{ $question->id }}">Strongly Disgree</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <hr>
                            <div class="form-group">
                                <label>Positive Comments:</label>
                                <textarea class="form-control" name="positive_comments" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Negative Comments:</label>
                                <textarea class="form-control" name="negative_comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('.datetimepicker-no-past').datetimepicker({
            minDate: new Date()
        });
    })
</script>