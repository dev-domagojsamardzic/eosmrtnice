@inject('carbon', 'Illuminate\Support\Carbon')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/post.post') }}
        </h2>
    </x-slot>

    <div class="row">
        {{-- Preview --}}
        <div class="col-lg-6 col-sm-12 d-flex align-items-start justify-content-center">
                @include('partials/post-preview')
        </div>
        {{-- Form --}}
        <div class="col-lg-6 col-sm-12 border">
            <form action="{{$action}}" method="POST">
                @csrf
                @if($post->exists)
                    {{ method_field('PUT') }}
                @endif

                <div class="form-group row">
                    <div class="col-sm-12">
                        <x-input-label for="type" :value="__('models/post.type')" :required_tag="true"/>
                        <select class="form-control border border-dark" id="type" name="type">
                            @foreach($types as $key => $type)
                                <option value="{{ $key }}" @selected($key === old('type', $post->type->value))>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <x-input-label for="size" :value="__('models/post.size')" :required_tag="true"/>
                        <select class="form-control border border-dark" id="size" name="size">
                            @foreach($sizes as $key => $size)
                                <option value="{{ $key }}" @selected($key === old('type', $post->size->value))>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-4 col-sm-12">
                        <x-input-label for="starts_at" :value="__('models/post.starts_at')" :required_tag="true"></x-input-label>
                        <div class="input-group input-group-joined date">
                            <input name="starts_at"
                                   id="starts_at"
                                   type="text"
                                   class="form-control"
                                   value="{{ $carbon::parse(old('starts_at', $post->starts_at ?? now()->toDateString()))->format('d.m.Y.') }}">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('starts_at')" class="mt-2"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="is_framed" id="is_framed">
                        <label class="custom-control-label" for="is_framed">
                            {{ __('models/post.is_framed') }}
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input-label for="full_name" :value="__('models/deceased.full_name')" />
                        <x-text-input id="full_name"
                                      type="text"
                                      name="full_name"
                                      value="{{ $deceased->full_name }}"
                                      placeholder="{{ __('models/post.full_name_of_deceased') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input-label for="lifespan" :value="__('models/deceased.born_died')" />
                        <x-text-input id="lifespan"
                                      type="text"
                                      name="lifespan"
                                      value="{{ $deceased->lifespan }}"
                                      placeholder="{{ __('models/deceased.lifespan') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('lifespan')" class="mt-2" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="intro_message" :value="__('models/post.intro_message')" />
                        <textarea id="intro_message" name="intro_message" class="form-control" rows="2">{{ old('intro_message', $post->intro_message) }}</textarea>
                        <x-input-error :messages="$errors->get('intro_message')" class="mt-2" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="main_message" :value="__('models/post.main_message')" />
                        <textarea id="main_message" name="main_message" class="form-control" rows="5">{{ old('main_message', $post->main_message) }}</textarea>
                        <x-input-error :messages="$errors->get('main_message')" class="mt-2" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="intro_message" :value="__('models/post.signature')" />
                        <textarea id="signature" name="signature" class="form-control" rows="3">{{ old('signature', $post->signature) }}</textarea>
                        <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-user">
                            {{ __('common.save') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    @push('scripts')
        <script type="module">
            $('#starts_at').datepicker({
                dateFormat: "dd.mm.yy.",
                autoSize: true,
                language: "hr",
            });
            $('#date_of_death').datepicker({
                dateFormat: "dd.mm.yy.",
                changeYear: true,
                autoSize: true,
            });
        </script>
    @endpush
</x-app-layout>
