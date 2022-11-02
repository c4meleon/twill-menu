@extends('layout.site')

@section('content')
    <p>{!! $item->renderBlocks(false) !!} </p>
@endsection
