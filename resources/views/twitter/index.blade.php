@extends('layouts.main')

@section('content')

  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
	    
    			<div class="row">
    				<div class="col-lg-12" style="height: 800px; overflow: auto;">

              <a class="twitter-timeline" href="https://twitter.com/rodneydc3?ref_src=twsrc%5Etfw">Tweets by rodneydc3</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    				</div>
    			</div>


        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{ asset('images/ivancik.jpg') }}');">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <h5 class="text-white font-weight-bolder mb-4 pt-2">Work with the rockets</h5>
            <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection