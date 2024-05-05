<div class="col-lg-12 col-md-12 mb-md-0 mb-4 mt-4">
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-lg-6 col-7">
          <h6>Recurring Posts</h6>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Platform</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Post At</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 145px;">Caption</th>
              {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Attachment</th> --}}
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>

            @forelse($postsRepeat as $postRepeat)

              @php
                $_post = $postRepeat->post;
              @endphp

            <tr>
              <td class="align-middle text-sm">
                <h6 class="mb-0 text-xs text-left ms-3">{{ $_post->platform->name }}</h6>
              </td>

              <td class="align-middle text-center text-sm">
                <span class="text-xs font-weight-bold">{{ $postRepeat->name }}</span>
              </td>

              <td class="align-middle text-center text-sm">
                <span class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse( $postRepeat->post_at )->format('M d, Y H:i') }}</span>
              </td>

              <td class="align-middle text-center text-sm">
                <span class="text-xs font-weight-bold">{{ Str::of($_post->caption)->limit(45) }}</span>
              </td>

              {{-- <td class="align-middle text-center text-sm">
                <span class="text-xs">
                  
                  @if($_post->file_id)
                    <a href="#" class="view-image">View Image</a>
                  @else
                    --
                  @endif

                </span>
              </td> --}}

              <td class="align-middle text-center text-sm">
                <span class="text-xs font-weight-bold">{{ $_post->user->name }}</span>
              </td>

              <td class="align-middle text-center text-sm">
                <a class="text-danger cancel-post-repeat" title="Cancel Scheduled Post" data-post-id="{{ $postRepeat->smm_post_id }}" style="cursor: pointer;">
                  <i class="fas fa-times-circle" aria-hidden="true"></i>
                </a>
              </td>

            </tr>

            @empty

                <tr>
                  <td class="align-middle t text-sm" colspan="6">
                    <span class="text-xs font-weight-bold">Posts not found.</span>
                  </td>
                </tr>

            @endforelse

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>