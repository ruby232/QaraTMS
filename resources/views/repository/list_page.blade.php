@extends('layout.base_layout')

@section('content')

    @include('layout.sidebar_nav')


    <div class="col">

        <div class="border-bottom my-3">
            <h3 class="page_title">
                {{__('Repositories')}}
                @can('add_edit_repositories')
                    <a class="mx-3" href="{{route("repository_create_page", $project->id)}}">
                        <button type="button" class="btn btn-sm btn-primary"> <i class="bi bi-plus-lg"></i>
                        {{__('Add New')}}
                        </button>
                    </a>
                @endcan
            </h3>
        </div>


        <div class="row row-cols-3 g-3">
            @foreach($repositories as $repository)

                <div class="col">
                    <div class="card h-100">

                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ route('repository_show_page', [$project->id, $repository->id]) }}">
                                    <i class="bi bi-stack"></i>
                                    {{$repository->title}}</a>
                            </h4>

                            @if($repository->description)
                                <div class="card-text">
                                    {{$repository->description}}
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                                <b>{{ $repository->suitesCount() }}</b> {{__('Test Suites')}}
                                 | <b>{{ $repository->casesCount() }}</b> {{__('Test Cases')}}
                                  | <b>{{ $repository->automatedCasesCount() }}</b> {{__('Automated')}}
                        </div>

                    </div>
                </div>

            @endforeach
        </div>

    </div>




@endsection


