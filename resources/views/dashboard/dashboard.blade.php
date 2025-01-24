@extends(session('layout') ?? 'layouts.app')
@section('content')
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" href="{{ asset('rappels/dashboard') }}" role="tab" aria-selected="false">Rappels</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="statistics-title">Nbr de dossiers</p>
                                            <h3 class="rate-percentage">{{ $details_dossier->count }}</h3>
                                            <p class="text-success d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle"></i>
                                                <span class="ms-2">{{ \Carbon\Carbon::parse($details_dossier->max)->format('d/m/Y') }}</span>
                                            </p>

                                        </div>
                                        <div>
                                            <p class="statistics-title">Devis non-signé/ signé</p>
                                            <h3 class="rate-percentage">{{ $details_devis->devis_non_signes }}</h3>
                                            <p class="text-success d-flex">{{ $details_devis->devis_signes }}</p>
                                        </div>
                                        <!--
                                        <div>
                                            <p class="statistics-title">New Sessions</p>
                                            <h3 class="rate-percentage">68.8</h3>
                                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Avg. Time on Site</p>
                                            <h3 class="rate-percentage">2m:35s</h3>
                                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">New Sessions</p>
                                            <h3 class="rate-percentage">68.8</h3>
                                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Avg. Time on Site</p>
                                            <h3 class="rate-percentage">2m:35s</h3>
                                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
