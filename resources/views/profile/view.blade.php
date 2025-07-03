@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5>Profile</h5>
                            </div>
                            <ul class="breadcrumb">
                                @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if (!$loop->last)
                                            <li class="breadcrumb-item">
                                                <a
                                                    href="{{ $breadcrumb['url'] ?? 'javascript:void(0)' }}">{{ $breadcrumb['label'] }}</a>
                                            </li>
                                        @else
                                            <li class="breadcrumb-item active" aria-current="page">
                                                {{ $breadcrumb['label'] }}</li>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">Profile Details</div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Username</dt>
                                <dd class="col-sm-8">{{ $user->username ?? 'N/A' }}</dd>

                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">{{ $user->name }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $user->email }}</dd>

                                <dt class="col-sm-4">Nomor Telepon</dt>
                                <dd class="col-sm-8">{{ $user->phone ?? 'N/A' }}</dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">{{ $user->gender ?? 'N/A' }}</dd>

                                <dt class="col-sm-4">Tanggal Lahir</dt>
                                <dd class="col-sm-8">{{ $user->birthdate ?? 'N/A' }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">{{ $user->address ?? 'N/A' }}</dd>

                                <dt class="col-sm-4">Foto Profil</dt>
                                <dd class="col-sm-8">
                                    @if ($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil"
                                            class="img-fluid" style="max-width: 150px;">
                                    @else
                                        <span>No photo available</span>
                                    @endif
                                </dd>
                            </dl>
                            <button type="button" id="editProfileBtn" class="btn btn-primary">
                                Edit Profile
                            </button>

                            <!-- Modal -->
                            <div id="editProfileModal" class="modal"
                                style="display:none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
                                <div class="modal-content"
                                    style="background-color: #fff; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 5px; position: relative;">
                                    <span id="closeModal"
                                        style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                                    <h4>Edit Profile</h4>
                                    <form method="POST" action="{{ route('profile.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group mb-3">
                                            <label for="username">Username</label>
                                            <input id="username" name="username" type="text" class="form-control"
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name">Nama Lengkap</label>
                                            <input id="name" name="name" type="text" class="form-control"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input id="email" name="email" type="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="phone">Nomor Telepon</label>
                                            <input id="phone" name="phone" type="text" class="form-control"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="gender">Jenis Kelamin</label>
                                            <select id="gender" name="gender" class="form-control">
                                                <option value=""
                                                    {{ old('gender', $user->gender) == '' ? 'selected' : '' }}>N/A</option>
                                                <option value="male"
                                                    {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female"
                                                    {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                                </option>
                                                <option value="other"
                                                    {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="birthdate">Tanggal Lahir</label>
                                            <input id="birthdate" name="birthdate" type="date" class="form-control"
                                                value="{{ old('birthdate', $user->birthdate) }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="address">Alamat</label>
                                            <textarea id="address" name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="profile_photo_path">Foto Profil</label>
                                            <input id="profile_photo_path" name="profile_photo_path" type="file"
                                                class="form-control">
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="cancelBtn"
                                                class="btn btn-secondary me-2">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.getElementById('editProfileBtn').addEventListener('click', function() {
                                    document.getElementById('editProfileModal').style.display = 'block';
                                });

                                document.getElementById('closeModal').addEventListener('click', function() {
                                    document.getElementById('editProfileModal').style.display = 'none';
                                });

                                document.getElementById('cancelBtn').addEventListener('click', function() {
                                    document.getElementById('editProfileModal').style.display = 'none';
                                });

                                // Close modal when clicking outside the modal content
                                window.onclick = function(event) {
                                    var modal = document.getElementById('editProfileModal');
                                    if (event.target == modal) {
                                        modal.style.display = 'none';
                                    }
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
