@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <strong>{{ $questionnaire->judul }}</strong>
                                </div>
                                <div class="col-sm-3 text-right">
                                    <a href="{{ route('questionnaire.publish') }}" class="btn btn-sm btn-danger">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-sm">

                                <tbody>
                                @foreach($question as $data)
                                    @php
                                    $answer = \App\Models\Answer::where('question.id', $data->_id)->get()
                                    @endphp
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}. {{ $data->question }} <br>
                                        @foreach($answer as $a)
                                            @if($data->tipe_jawaban == "pilihan ganda")
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="{{ $a->_id }}">
                                                <label class="form-check-label" for="exampleRadios1">
                                                    {{ $a->answer }}
                                                </label>
                                            </div>
                                            @elseif($data->tipe_jawaban == "ceklis")
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $a->_id }}" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        {{ $a->answer }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
