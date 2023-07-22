@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    {{ $title }}
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="{{ route('questionnaire.index') }}" class="btn btn-sm btn-danger">Back</a>
                                </div>

                            </div>

                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>Judul</td>
                                    <td>:</td>
                                    <td>{{ $questionnaire->judul }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Mulai</td>
                                    <td>:</td>
                                    <td>{{ $questionnaire->tanggal_mulai }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Selesai</td>
                                    <td>:</td>
                                    <td>{{ $questionnaire->tanggal_selesai }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>{{ $questionnaire->status }}</td>
                                </tr>
                            </table>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                                Add Question
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('question.store') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Creat Question</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Question</label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" class="form-control" name="questionnaire_id" value="{{ $questionnaire->_id }}">
                                                        <input type="text" class="form-control" name="question">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Jawaban</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name="tipe_jawaban">
                                                            <option value="pilihan ganda">Pilihan Ganda</option>
                                                            <option value="isian">Esai</option>
                                                            <option value="ceklis">Ceklist</option>
                                                        </select>

                                                    </div>
                                                    <label class="col-sm-2 col-form-label">Bobot</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" class="form-control" name="bobot">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <table class="table table-sm">
                                <thead>
                                <th>#</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Option</th>
                                </thead>
                                <tbody>
                                @foreach($question as $data)
                                    @php
                                        $answer = \App\Models\Answer::where('question.id', $data->_id)->get()
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $data->question }} <br>
                                            @foreach($answer as $a)
                                                @if($data->tipe_jawaban == "pilihan ganda")
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="{{ $a->_id }}" @if( $a->is_answer == true ) checked @endif>
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
                                        <td>{{ $data->tipe_jawaban }}</td>
                                        <td>
                                            @if($data->tipe_jawaban != "isian")
                                                <button type="button" class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#jawaban{{ $data->_id }}">
                                                    Add Option
                                                </button>
                                            @endif
                                            <!-- Button trigger modal -->


                                            <!-- Modal -->
                                            <div class="modal fade" id="jawaban{{ $data->_id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('answer.store') }}" method="post">
                                                            @csrf
                                                            <div class="modal-header bg-black">
                                                                <h5 class="modal-title">Tambah Opsi Jawaban <br> {{ $data->question }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" class="form-control" name="question_id" required value="{{ $data->_id }}">
                                                                <input type="text" class="form-control" name="answer" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
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
