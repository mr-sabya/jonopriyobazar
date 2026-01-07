<div class="profile-card profile text-center">
    <div align="center" id="profile_image">
        <div class="image">
            @if(Auth::user()->image == '')
            <img class="img-fluid w-100" src="{{ Avatar::create('John Doe')->toBase64() }}" alt="">
            @else
            <img class="img-fluid w-100" src="{{ url('upload/profile_pic', Auth::user()->image) }}" alt="">
            @endif

            <a href="javascript:void(0)" id="edit_image"><i class="fas fa-pencil-alt"></i></a>
        </div>
    </div>
    <div align="center" id="image_upload" style="display: none;">
        <div class="image_upload" style="width: 214px">
            <form id="image_form" action="{{ route('user.image.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-group">
                    <input type="file" name="image" id="image" data-height="200" data-allowed-formats="portrait square">
                    <small style="color: red" id="image_error"></small>
                </div>
                <button type="submit" class="w-100 btn btn-success mt-2">Change</button>
            </form>
            <a href="javascript:void(0)" id="close_edit"><i class="fas fa-times"></i></a>
        </div>
    </div>
    <div class="mt-3">
        @if(Auth::user()->is_varified == 1)
        <span class="badge badge-primary">Verified</span>
        @else
        <span class="badge badge-warning">Unverified</span>
        @endif
    </div>

    <div class="mt-3">
        <p>Refer Code: <span id="code">{{ Auth::user()->affiliate_code }}</span> <button class="copy-btn" onclick="copyCode()"><i class="fas fa-copy"></i></button></p>
    </div>

    

    <div class="mt-3">
        <h3 class="p-0 m-0">{{ Auth::user()->name }}</h3>
        <p class="p-0 m-0">{{ Auth::user()->phone}}</p>
    </div>
</div>