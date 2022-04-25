@extends('layouts.app')
@section('title', 'Registered pets')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="tab-content text-center mb-3">
                <div class="w-100 d-flex justify-content-between align-items-center mb-3">
                    <h1 class="text-start">Registered pets</h1>
                    <a href="{{ route('new-pet') }}" type="button" class="btn btn-success btn-sm h-auto">New pet</a>
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show my-3 text-start">
                        {!! Session::get("message") !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <table class="table caption-top text-start">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Owner Email</th>
                        <th scope="col">Breed</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pets as $pet)
                        <tr>
                            <th scope="row">{{ $pet->id }}</th>
                            <td>{{ $pet->pet_name }}</td>
                            <td>{{ $pet->owner_email }}</td>
                            <td>{{ $pet->breed }}</td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tr-{{ $pet->id }}" aria-expanded="false" aria-controls="collapseWidthExample">
                                    Details
                                </button>
                                <a href="{{ route('delete-pet', $pet->id) }}" type="button" class="btn btn-sm btn-danger m-auto">Delete</a>
                            </td>
                        </tr>
                        <tr class="collapse collapse-horizontal fade" id="collapse-tr-{{ $pet->id }}">
                            <td colspan="5">
                                <div class=" w-100" >
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-2">
                                                @if(!empty($pet->photo))
                                                    <img src="{{ asset("/storage/".$pet->photo) }}" class="img-thumbnail" alt="{{ $pet->pet_name }} photo">
                                                @else
                                                    <img src="{{ asset("/images/dog.png") }}" class="img-thumbnail" alt="Dog photo">
                                                @endif
                                            </div>
                                            <div class="col-10 d-flex justify-content-around">
                                                <div class="w-50">
                                                    <p class="mb-1"><b>Gender:</b> <br> {!! (!empty($pet->gender)) ? ucfirst($pet->gender) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    <p class="mb-1"><b>Birthdate:</b> <br> {!! !empty($pet->birthdate) ? $pet->birthdate : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    <p class="mb-1"><b>Weight:</b> <br> {!! (!empty($pet->weight)) ? $pet->weight : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    <p class="mb-1"><b>Ideal weight:</b></b> <br> {!! (!empty($pet->ideal_weight)) ? $pet->ideal_weight : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    <p class="mb-1"><b>Lifestyle:</b> <br> {!! (!empty($pet->lifestyle)) ? ucfirst($pet->lifestyle) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    <p class="mb-1"><b>Goal:</b> <br> {!! (!empty($pet->goal)) ? ucfirst($pet->goal) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                </div>
                                                <div class="w-50">
                                                    @if($pet->gender == 'girl')
                                                        <p class="mb-1"><b>Is spayed:</b> <br> {!! (!empty($pet->is_spayed)) ? ucfirst($pet->is_spayed) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                        <p class="mb-1"><b>Is pregnant:</b> <br> {!! (!empty($pet->is_pregnant)) ? ucfirst($pet->is_pregnant) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    @else
                                                        <p class="mb-1"><b>Is neutered:</b> <br> {!! (!empty($pet->is_neutered)) ? ucfirst($pet->is_neutered) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                    @endif
                                                    @if($pet->have_allergies == 'yes' OR $pet->have_allergies == null)
                                                        <p class="mb-1"><b>Allergies:</b> <br> {!! (!empty($pet->allergies)) ? ucfirst($pet->allergies) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                        @if(!empty($pet->other_allergies))
                                                            <p class="mb-1"><b>Other Allergies:</b> <br> {!! (!empty($pet->other_allergies)) ? ucfirst($pet->other_allergies) : '<span class="badge bg-secondary">Not specified</span>' !!}</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-warning text-start" role="alert">
                                    No pets were found in the database.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

