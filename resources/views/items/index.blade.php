@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">@lang('global.items.title')</div>
                <a href="{{ route('items.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
        </div>
        <div class="card-body">
                {!! $grid or '' !!}
        </div>
    </div>
	
	
	{{----}}
	
	<!-- Modal -->
	<div class="modal fade" id="itemImage" tabindex="-1" role="dialog" aria-labelledby="itemImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header alert-primary">
            <h5 class="modal-title" id="itemImageLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
            <img id='itemImageUrl' src="" class="rounded img-thumbnail mx-auto  d-block"/>
        </div>
      
    </div>
  </div>
</div>
	{{----}}

@stop

@section('javascript')
	<script>
		$(function () {
            $("td a.btn").click(function (e) {
                e.stopPropagation();
            });

            $('.openImage').on('click', function () {
                var url  = $(this).data('url');
                var code = $(this).data('code');
                $("#itemImageLabel").text(code);

                $("#itemImageUrl").attr("src", url);
                $('#itemImage').modal('show');
            });

        })
	</script>
@endsection
