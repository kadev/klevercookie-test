@extends('layouts.app')
@section('title', 'Custom Meal Plan')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">My Dog</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button disabled class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Meals Plans</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button disabled class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Place order</button>
                </li>
            </ul>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="tab-content text-center mb-3" id="pills-tabContent">
                <form id="pet-info-form" method="post" action="{{ route('create-custom-plan') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <div class="tab-pane fade show active" data-section="my-dog" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div data-step="1" class="kc-step">
                            <h1>What is your pup’s name?</h1>
                            <p>
                                Your pup’s health matters! Just answer a few quick questions. We’ll use the information to customize the perfect meal plan for your pup.
                            </p>
                            <img class="img-fluid" id="image-output" width="300" height="240" src="https://cdn.shopify.com/s/files/1/0281/2723/2132/files/pet-profile-img.png">
                            <div class="mb-3">
                                <input class="form-control form-control-sm mt-3" id="image-file" name="image-file" type="file" accept="image/*" onchange="loadFile(event)">
                            </div>

                            <input type="email" class="form-control mt-5" name="email" placeholder="Email" value="{{ old('email') }}">
                            <p class="message-error mt-2 d-none"><small>Please enter this field, it is required.</small></p>
                            <input id="pup-name" name="pup-name" type="text" class="form-control mt-5" placeholder="Your pup" value="{{ old('pup-name') }}">
                            <p class="message-error mt-2 d-none"><small>Please enter this field, it is required.</small></p>
                        </div>

                        <div data-step="2" class="d-none kc-step">
                            <h1 class="mb-5"><span class="pup-label"></span> is a...</h1>
                            <div class="button-options d-flex justify-content-center align-items-center">
                                <span class="btn btn-lg btn-secondary btn-option me-3 {{ (old('pup-gender') == 'boy') ? 'active' : '' }}" data-value="boy" data-input="pup-gender">Very good boy</span>
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('pup-gender') == 'girl') ? 'active' : '' }}" data-value="girl" data-input="pup-gender">Very good girl</span>
                                <input class="show-ask-if" data-if-is="girl" data-next-question="qc-spayed" data-other-response="qc-neutered" type="hidden" value="{{ old('pup-gender') }}" name="pup-gender">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>
                            </div>

                            <div id="qc-neutered" class="{{ (old('pup-gender') != 'boy') ? 'd-none' : '' }} mt-5">
                                <h1 class="mb-5">Is <span class="pup-label"></span> neutered...</h1>
                                <span class="btn btn-lg btn-secondary btn-option me-3 {{ (old('neutered') == 'yes') ? 'active' : '' }}" data-value="yes" data-input="neutered">Yes</span>
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('neutered') == 'no') ? 'active' : '' }}" data-value="no" data-input="neutered">No</span>
                                <input type="hidden" value="{{ old('neutered') }}" name="neutered">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>
                            </div>

                            <div id="qc-spayed" class="{{ (old('pup-gender') != 'girl') ? 'd-none' : '' }} mt-5">
                                <h1 class="mb-5">Is <span class="pup-label"></span> spayed...</h1>
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('spayed') == 'yes') ? 'active' : '' }} me-3" data-value="yes" data-input="spayed">Yes</span>
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('spayed') == 'no') ? 'active' : '' }}" data-value="no" data-input="spayed">No</span>
                                <input class="show-ask-if" data-if-is="no" data-next-question="qc-pregnant" type="hidden" value="{{ old('spayed') }}" name="spayed">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>

                                <div id="qc-pregnant" class="{{ (old('spayed') != 'no') ? 'd-none' : '' }} mt-5">
                                    <h1 class="mb-5">Is <span class="pup-label"></span> pregnant...</h1>
                                    <span class="btn btn-lg btn-secondary btn-option {{ (old('pregnant') == 'yes') ? 'active' : '' }} me-3" data-value="yes" data-input="pregnant">Yes</span>
                                    <span class="btn btn-lg btn-secondary btn-option {{ (old('pregnant') == 'no') ? 'active' : '' }}" data-value="no" data-input="pregnant">No</span>
                                    <input type="hidden" value="{{ old('pregnant') }}" name="pregnant">
                                    <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>
                                </div>
                            </div>
                        </div>

                        <div data-step="3" class="d-none kc-step">
                            <h1 class="mb-5">Does <span class="pup-label"></span> have any allergies?</h1>
                            <div class="button-options d-flex justify-content-center align-items-center">
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('have-allergies') == 'yes') ? 'active' : '' }} me-3" data-value="yes" data-input="have-allergies">Yes</span>
                                <span class="btn btn-lg btn-secondary btn-option {{ (old('have-allergies') == 'no') ? 'active' : '' }}" data-value="no" data-input="have-allergies">No</span>
                                <input class="show-ask-if" data-if-is="yes" data-next-question="qc-allergies-list" type="hidden" value="{{ old('have-allergies') }}" name="have-allergies">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>
                            </div>

                            <div id="qc-allergies-list" class="{{ (old('have-allergies') != 'yes') ? 'd-none' : '' }} mt-5">
                                <h1 class="mb-5">Please chech the box for any allergy that applies:</h1>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Chicken')) ? 'active' : '' }}" data-value="Chicken" data-input="allergies">
                                            Chicken
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Wheat')) ? 'active' : '' }}" data-value="Wheat" data-input="allergies">
                                            Wheat
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Rice')) ? 'active' : '' }}" data-value="Rice" data-input="allergies">
                                            Rice
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Peas')) ? 'active' : '' }}" data-value="Peas" data-input="allergies">
                                            Peas
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Egg')) ? 'active' : '' }}" data-value="Egg" data-input="allergies">
                                            Egg
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Peanut butter')) ? 'active' : '' }}" data-value="Peanut butter" data-input="allergies">
                                            Peanut butter
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Beef')) ? 'active' : '' }}" data-value="Beef" data-input="allergies">
                                            Beef
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Dairy')) ? 'active' : '' }}" data-value="Dairy" data-input="allergies">
                                            Dairy
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Lamb')) ? 'active' : '' }}" data-value="Lamb" data-input="allergies">
                                            Lamb
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Soy')) ? 'active' : '' }}" data-value="Soy" data-input="allergies">
                                            Soy
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Pork')) ? 'active' : '' }}" data-value="Pork" data-input="allergies">
                                            Pork
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Rabbit')) ? 'active' : '' }}" data-value="Rabbit" data-input="allergies">
                                            Rabbit
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Salmon')) ? 'active' : '' }}" data-value="Salmon" data-input="allergies">
                                            Salmon
                                        </span>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="btn btn-lg btn-secondary btn-multiple-option me-3 w-100 {{ (str_contains(old('allergies'), 'Other Fish')) ? 'active' : '' }}" data-value="Other Fish" data-input="allergies">
                                            Other Fish
                                        </span>
                                    </div>
                                    <input type="hidden" value="{{ old('allergies') }}" name="allergies">

                                    <div class="col-12 my-5">
                                        <input type="text" class="form-control" placeholder="Other allergy" value="{{ old('other-allergy') }}" name="other-allergy">
                                        <p class="text-start mt-2"><small>Please write in any other known allergy you think we should know about (Separate by comma).</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-step="4" class="d-none kc-step">
                            <h1 class="mb-5">What breed is <span class="pup-label"></span>?</h1>
                            <p>We love All dogs!</p>
                            <select  class="form-select" name="breed" placeholder="Breeds">
                                <option value="">Select one</option>
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->name }}" {{ (old('breed') == $breed->name) ? 'selected' : '' }}>{{ $breed->name }}</option>
                                @endforeach
                            </select>
                            <p class="message-error mt-2 d-none"><small>Please enter this field, it is required.</small></p>
                        </div>

                        <div data-step="5" class="d-none kc-step">
                            <h1 class="mb-5">Please enter <span class="pup-label"></span> birthdate?</h1>
                            <p>Understanding <span class="pup-label"></span>'s life stage helps us recommend the perfect diet.</p>

                            <input type="date" name="birthdate" class="form-control" placeholder="Date" value="{{ old('birthdate') }}">
                            <p class="message-error mt-2 d-none"><small>Please enter this field, it is required.</small></p>
                        </div>

                        <div data-step="6" class="d-none kc-step">
                            <h1 class="mb-5">How much does <span class="pup-label"></span> weight?</h1>
                            <p>If you have an exact weight, great! Otherwise, please approximate to the best of your ability.</p>

                            <input type="text" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight') }}">
                            <p class="message-error mt-2 d-none"><small>Please enter this field, it is required.</small></p>

                            <h1 class="my-5">What does your vet say <span class="pup-label"></span>'s ideal weight?</h1>
                            <p>If you know it, let us know! Otherwise you can skip this.</p>

                            <input type="text" name="ideal-weight"  class="form-control" placeholder="Weight according to the vet" value="{{ old('ideal-weight') }}">
                        </div>

                        <div data-step="7" class="d-none kc-step">
                            <h1 class="">What's <span class="pup-label"></span> lifestyle?</h1>
                            <p class="mb-5">We want to make sure <span class="pup-label"></span> gets just the right amount of food for her activity level.</p>

                            <div class="row">
                                <div class="col-6">
                                    <div class="lifestyle-option btn-option {{ (old('lifestyle') == 'inactive') ? 'active' : '' }}" data-value="inactive" data-input="lifestyle">
                                        <div class="title d-flex align-items-center justify-content-between">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 81.000000 54.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,54.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M489 513 c-6 -15 -23 -63 -37 -106 -25 -74 -30 -80 -70 -99 -55 -26 -99 -80 -110 -135 -10 -46 -2 -104 18 -128 10 -12 9 -15 -4 -15 -32 0 -83 28 -103 56 -12 16 -24 26 -28 22 -12 -12 33 -65 69 -82 26 -12 65 -16 164 -16 144 0 163 8 119 46 -21 18 -25 27 -18 46 7 21 11 18 46 -35 31 -47 43 -57 66 -57 16 0 29 4 29 10 0 5 -16 34 -35 64 -34 54 -35 57 -35 161 l0 105 25 0 c15 0 38 12 52 26 26 26 26 27 8 40 -10 8 -24 14 -30 14 -15 0 -55 55 -55 75 0 18 -12 19 -28 3 -9 -9 -12 -8 -12 4 0 30 -20 30 -31 1z"/></g></svg>
                                            <span class="w-50 text-start">Inactive</span>
                                        </div>
                                        <div class="description">Under 30 minutes of exercise per day.</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="lifestyle-option btn-option {{ (old('lifestyle') == 'moderately activity') ? 'active' : '' }}" data-value="moderately activity" data-input="lifestyle">
                                        <div class="title d-flex align-items-center justify-content-between">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 81.000000 54.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,54.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M551 518 c-5 -13 -21 -58 -36 -100 l-27 -76 -83 -7 c-46 -4 -120 -6 -165 -3 -78 3 -83 5 -111 36 -17 18 -35 31 -42 29 -13 -4 58 -81 82 -89 12 -3 12 -10 3 -38 -9 -24 -9 -44 -2 -72 9 -33 8 -43 -9 -66 -16 -24 -18 -35 -10 -76 10 -57 13 -61 33 -53 11 4 13 15 10 39 -6 31 -2 36 55 77 33 24 62 49 65 56 3 9 24 9 93 -2 48 -9 91 -18 96 -22 4 -4 13 -38 20 -77 9 -49 17 -69 27 -69 12 0 17 19 22 80 3 44 15 116 25 160 19 76 20 79 54 88 38 10 56 22 70 49 8 15 5 20 -18 30 -37 16 -83 67 -83 92 0 16 -3 17 -12 8 -16 -16 -28 -15 -28 2 0 26 -20 28 -29 4z"/></g></svg>
                                            <span class="w-50 text-start">Moderately Activity</span>
                                        </div>
                                        <div class="description">At least 60 minutes of moderate exercise per day.</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="lifestyle-option btn-option {{ (old('lifestyle') == 'active') ? 'active' : '' }}" data-value="active" data-input="lifestyle">
                                        <div class="title d-flex align-items-center justify-content-between">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 81.000000 54.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,54.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M530 431 c-25 -69 -37 -91 -54 -95 -12 -3 -73 -6 -136 -7 -124 -1 -159 8 -185 48 -9 13 -20 21 -25 18 -15 -9 16 -50 54 -70 l34 -18 -19 -31 c-10 -17 -19 -38 -19 -47 0 -9 -13 -22 -29 -28 -28 -12 -67 -83 -55 -102 11 -18 30 -8 41 21 14 38 57 44 48 7 -8 -37 9 -91 29 -95 17 -4 18 1 13 35 -6 36 -4 40 24 57 17 10 46 31 63 47 l33 29 84 -15 c46 -8 84 -15 85 -15 0 0 22 -29 48 -65 66 -90 103 -88 51 2 l-24 43 25 0 c14 0 24 -6 24 -14 0 -19 19 -31 30 -20 4 5 11 19 14 31 6 18 0 23 -44 38 l-51 17 7 36 c15 77 19 84 59 98 51 17 88 64 50 64 -22 0 -85 60 -85 81 0 10 -4 19 -10 19 -5 0 -10 -4 -10 -10 0 -5 -4 -10 -10 -10 -5 0 -10 6 -10 14 0 43 -21 15 -50 -63z"/></g></svg>
                                            <span class="w-50 text-start">Active</span>
                                        </div>
                                        <div class="description">At least 2-4 hours of exercise per day.</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="lifestyle-option btn-option {{ (old('lifestyle') == 'very active') ? 'active' : '' }}" data-value="very active" data-input="lifestyle">
                                        <div class="title d-flex align-items-center justify-content-between">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 81.000000 54.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,54.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M629 488 c-1 -7 -1 -18 0 -25 1 -7 -20 -19 -47 -27 -53 -15 -100 -10 -181 18 -66 24 -99 20 -185 -24 -100 -51 -143 -53 -181 -9 -30 36 -40 33 -30 -10 8 -36 67 -91 98 -91 13 0 40 9 60 19 35 18 39 18 44 3 3 -9 23 -33 45 -52 38 -34 39 -38 40 -100 1 -86 30 -149 64 -142 30 6 30 17 -1 54 -14 16 -25 41 -25 55 0 14 11 38 25 55 14 16 25 36 25 44 0 18 4 18 40 -1 25 -13 30 -22 30 -50 0 -19 -3 -35 -7 -35 -5 0 -23 -9 -42 -21 -46 -28 -29 -45 29 -27 32 10 45 20 52 41 11 31 23 35 32 10 4 -11 -4 -25 -26 -44 -37 -32 -26 -37 27 -12 31 15 35 21 35 53 0 32 5 39 38 58 38 22 71 50 109 95 18 21 29 25 50 21 21 -4 33 0 48 17 15 16 17 23 7 27 -7 2 -39 29 -70 59 -31 31 -58 50 -60 44 -3 -8 -9 -8 -23 -1 -14 8 -19 7 -20 -2z"/></g></svg>
                                            <span class="w-50 text-start">Very Active</span>
                                        </div>
                                        <div class="description">Working dog. Over 4 hours of vigorous exercise per day.</div>
                                    </div>
                                </div>

                                <input type="hidden" name="lifestyle" value="{{ old('lifestyle') }}">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>

                            </div>
                        </div>

                        <div data-step="8" class="d-none kc-step">
                            <h1>What's <span class="pup-label"></span> goal for the next month?</h1>
                            <p class="mb-5">We want to make sure <span class="pup-label"></span> gets just the right amount of food for her activity level.</p>

                            <div class="row">
                                <div class="col-4">
                                    <div class="goal-option btn-option {{ (old('goal') == 'weight loss') ? 'active' : '' }}" data-value="weight loss" data-input="goal">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 70.000000 60.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M475 572 c-40 -25 -51 -40 -62 -82 -10 -39 -8 -38 -174 -58 -42 -5 -91 -17 -109 -25 -23 -12 -37 -14 -51 -6 -27 14 -49 62 -49 104 0 49 -17 35 -25 -19 -8 -54 7 -105 40 -136 21 -20 25 -33 25 -84 0 -42 -6 -70 -18 -89 -17 -24 -17 -35 -8 -95 l11 -67 44 0 c53 0 62 16 27 48 -36 34 -32 53 13 77 22 11 44 27 48 35 7 12 16 13 47 4 35 -10 107 -6 142 8 12 4 18 -13 60 -159 4 -14 16 -18 55 -18 42 0 49 3 49 20 0 11 -11 27 -25 36 -34 22 -32 52 8 104 17 24 38 52 46 62 9 12 16 53 19 104 l4 83 44 17 c34 13 44 23 49 46 8 33 -8 58 -37 58 -11 0 -33 11 -50 25 -35 30 -81 32 -123 7z"/></g></svg>
                                        <p class="mb-0">Weight Loss</p>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="goal-option btn-option {{ (old('goal') == 'maintain weight') ? 'active' : '' }}" data-value="maintain weight" data-input="goal">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 70.000000 60.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M500 579 c-40 -16 -69 -49 -76 -85 -3 -18 -12 -38 -20 -45 -7 -6 -68 -17 -135 -24 -75 -9 -130 -20 -145 -30 -21 -13 -28 -14 -40 -4 -26 21 -44 66 -44 109 0 51 -16 44 -25 -10 -9 -55 1 -94 36 -131 25 -27 29 -39 29 -88 0 -35 -7 -69 -18 -90 -15 -28 -16 -43 -9 -102 l10 -69 43 0 c40 0 44 2 44 25 0 14 -8 29 -20 35 -30 16 -27 67 5 82 13 6 33 28 43 48 16 33 20 36 42 28 14 -6 64 -8 111 -5 l87 4 5 -36 c3 -20 9 -69 13 -108 l7 -73 48 0 c45 0 49 2 49 23 0 16 -9 28 -25 35 -33 15 -32 36 10 157 19 55 35 116 35 136 0 45 34 79 78 79 26 0 35 5 43 27 14 38 8 57 -21 61 -14 2 -36 14 -50 28 -30 28 -75 38 -110 23z"/></g></svg>
                                        <p class="mb-0">Maintain Weight</p>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="goal-option btn-option {{ (old('goal') == 'weight gain') ? 'active' : '' }}" data-value="weight gain" data-input="goal">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60px" height="44px" viewBox="0 0 70.000000 60.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" fill="#2e4b56" stroke="none"><path d="M485 568 c-19 -17 -27 -36 -32 -74 -7 -66 -16 -70 -171 -85 -104 -10 -146 -19 -204 -43 -25 -11 -52 47 -52 116 -1 65 -12 67 -21 4 -8 -54 -1 -78 34 -119 21 -24 30 -47 35 -93 6 -57 5 -64 -19 -92 -25 -30 -25 -32 -14 -101 l12 -71 43 0 c36 0 44 3 44 18 0 11 -11 24 -25 30 -42 19 -42 54 2 119 l38 58 100 0 c55 0 117 4 137 8 l37 8 3 -118 3 -118 49 0 c52 0 77 21 36 32 -46 12 -51 77 -15 183 14 40 25 94 25 120 0 59 26 86 93 95 37 6 51 13 59 31 15 31 4 54 -26 54 -14 0 -33 8 -43 19 -44 45 -89 52 -128 19z"/></g></svg>
                                        <p class="mb-0">Weight Gain</p>
                                    </div>
                                </div>

                                <input type="hidden" name="goal" value="{{ old('goal') }}">
                                <p class="message-error mt-2 d-none w-100 text-center"><small>Please enter this field, it is required.</small></p>

                            </div>
                        </div>
                    </div>

                    <div class="actions mt-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <a id="go-back" class="d-none" href="javascript:void(0);">
                                    <svg style="width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg>
                                    Previous question
                                </a>
                            </div>
                            <span id="step-continue" class="btn btn-primary btn-rounded" data-section="my-dog" data-step="1">Continue</span>
                            <span id="send-data" class="btn btn-primary btn-rounded" style="display: none;">Send</span>
                        </div>
                        <label class="d-block fw-bold"><span id="current-step">1</span>/8</label>
                        <label class="d-block">My Dog</label>
                    </div>
                </form>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
            </div>

            <p class="text-center text-muted mb-5"><a href="{{ route('pets') }}" style="color: gray">Sofya is that you? Go to registered pets.</a></p>

        </div>
    </div>
@endsection
