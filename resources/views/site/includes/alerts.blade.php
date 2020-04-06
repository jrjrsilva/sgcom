@if(session('success'))
    <div id="alert" class="alert alert-success">
           {{session('success')}} 
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
    </div>
@endif

@if(session('errors'))
    <div id="alert" class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> 
            </p>
        @endforeach
        
    </div>
@endif
