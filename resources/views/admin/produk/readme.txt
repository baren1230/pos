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
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                        </div>