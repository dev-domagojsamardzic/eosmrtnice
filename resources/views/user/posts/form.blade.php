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

                {{-- Post type --}}
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

                {{-- Post size --}}
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

                {{-- Starts at --}}
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

                {{-- Is framed --}}
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="is_framed" id="is_framed">
                        <label class="custom-control-label" for="is_framed">
                            {{ __('models/post.is_framed') }}
                        </label>
                    </div>
                </div>

                {{-- Deceased full_name - LG --}}
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-12">
                        <x-input-label for="deceased_full_name_lg" :value="__('models/deceased.full_name')" :required_tag="true"/>
                        <x-input-info :content="__('models/post.deceased_full_name_lg_info')"/>
                        <x-text-input id="deceased_full_name_lg"
                                      type="text"
                                      name="deceased_full_name_lg"
                                      value="{{ $deceased->full_name }}"
                                      placeholder="{{ __('models/post.deceased_full_name_lg_placeholder') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('deceased_full_name_lg')" class="mt-2" />
                    </div>
                </div>

                {{-- Lifespan --}}
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input-label for="lifespan" :value="__('models/deceased.born_died')" :required_tag="true"/>
                        <x-input-info :content="__('models/post.lifespan_info')"/>
                        <x-text-input id="lifespan"
                                      type="text"
                                      name="lifespan"
                                      value="{{ $deceased->lifespan }}"
                                      placeholder="{{ __('models/post.lifespan_placeholder') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('lifespan')" class="mt-2" />
                    </div>
                </div>

                {{-- Intro message --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="intro_message" :value="__('models/post.intro_message')" />
                        <textarea id="intro_message" name="intro_message" class="form-control" rows="2">{{ old('intro_message', $post->intro_message) }}</textarea>
                        <x-input-error :messages="$errors->get('intro_message')" class="mt-2" />
                    </div>
                </div>

                {{-- Deceased full_name - SM --}}
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-12">
                        <x-input-label for="deceased_full_name_sm" :value="__('models/post.deceased_full_name_sm')"/>
                        <x-input-info :content="__('models/post.deceased_full_name_sm_info')"/>
                        <x-text-input id="deceased_full_name_sm"
                                      type="text"
                                      name="deceased_full_name_sm"
                                      value="{{ $deceased->full_name }}"
                                      placeholder="{{ __('models/post.deceased_full_name_sm_placeholder') }}"/>
                        <x-input-error :messages="$errors->get('deceased_full_name_sm')" class="mt-2" />
                    </div>
                </div>

                {{-- Main message --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="main_message" :value="__('models/post.main_message')" />
                        <textarea id="main_message" name="main_message" class="form-control" rows="5">{{ old('main_message', $post->main_message) }}</textarea>
                        <x-input-error :messages="$errors->get('main_message')" class="mt-2" />
                    </div>
                </div>

                {{-- Signature --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="signature" :value="__('models/post.signature')" />
                        <textarea id="signature"
                                  name="signature"
                                  class="form-control"
                                  rows="3"
                                  placeholder="{{ __('models/post.signature_placeholder') }}">
                            {!! $post->signature !!}
                        </textarea>
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

            document.getElementById('deceased_full_name_lg').addEventListener('input', function(event) {
                document.getElementById('deceased_full_name_lg_preview').innerHTML = event.target.value.replace(/\n/g, "<br>");
            })

            document.getElementById('lifespan').addEventListener('input', function(event) {
                document.getElementById('lifespan_preview').innerHTML = event.target.value.replace(/\n/g, "<br>");
            })

            document.getElementById('intro_message').addEventListener('input', function(event) {
                document.getElementById('intro_message_preview').innerHTML = event.target.value.replace(/\n/g, "<br>");
            })

            document.getElementById('main_message').addEventListener('input', function(event) {
                document.getElementById('main_message_preview').innerHTML = event.target.value.replace(/\n/g, "<br>");
            });

            document.getElementById('signature').addEventListener('input', function(event) {
                document.getElementById('signature_preview').innerHTML = event.target.value.replace(/\n/g, "<br>");
            });
        </script>
    @endpush
</x-app-layout>
