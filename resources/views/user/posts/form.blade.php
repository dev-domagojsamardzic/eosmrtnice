@inject('carbon', 'Illuminate\Support\Carbon')
@inject('Str', 'Illuminate\Support\Str')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/post.post') }}
        </h2>
    </x-slot>

    <div class="row">
        {{-- Preview --}}
        <div class="col-lg-6 col-sm-12 d-flex align-items-start justify-content-center mb-3">
            @include('partials/post-preview')
        </div>
        {{-- Form --}}
        <div class="col-lg-6 col-sm-12 border">
            <form action="{{$action}}" method="POST">
                @csrf
                @if($post->exists)
                    {{ method_field('PUT') }}
                @endif


                {{-- Post size --}}
                <div class="form-group row">
                    <div class="col-sm-12">
                        <x-input-label for="size" :value="__('models/post.size')" :required_tag="true"/>
                        <x-input-info :content="__('models/post.size_info')"/>
                        <select class="form-control border border-dark" id="size" name="size">
                            @foreach($sizes as $key => $size)
                                <option
                                    value="{{ $key }}" @selected($key === (int)old('type', $post->size->value))>{{ $size }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('size')" class="mt-2"/>
                        <hr>
                        <p class="mt-2 font-weight-bold">{{ __('models/post.current_word_count') }}:
                            <span id="message_counter" class="text-counter-success font-weight-bold"></span>
                        </p>
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

                <h3>{{ __('models/post.edit_post') }}</h3>
                <p>{{ __('models/post.edit_post_instructions') }}</p>
                <hr>

                {{-- Is framed --}}
                <div class="form-group row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_framed" id="is_framed" @checked((bool)old('is_framed', $post->is_framed))>
                            <label class="custom-control-label" for="is_framed">
                                {{ __('models/post.is_framed') }}
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Post type --}}
                <div class="form-group row">
                    <div class="col-sm-12">
                        <x-input-label for="type" :value="__('models/post.type')" :required_tag="true"/>
                        <select class="form-control border border-dark" id="type" name="type">
                            @foreach($types as $key => $type)
                                <option
                                    value="{{ $key }}" @selected($key === (int)old('type', $post->type->value))>{{ $type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                    </div>
                </div>

                {{-- Deceased full_name - LG --}}
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-12">
                        <x-input-label for="deceased_full_name_lg" :value="__('models/post.deceased_full_name')" :required_tag="true"/>
                        <x-input-info :content="__('models/post.deceased_full_name_lg_info')"/>
                        <x-text-input id="deceased_full_name_lg"
                                      type="text"
                                      name="deceased_full_name_lg"
                                      value="{{ old('deceased_full_name_lg', $post->deceased_full_name_lg) }}"
                                      placeholder="{{ __('models/post.deceased_full_name_lg_placeholder') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('deceased_full_name_lg')" class="mt-2"/>
                    </div>
                </div>

                {{-- Lifespan --}}
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input-label for="lifespan" :value="__('models/post.deceased_born_died')" :required_tag="true"/>
                        <x-input-info :content="__('models/post.lifespan_info')"/>
                        <x-text-input id="lifespan"
                                      type="text"
                                      name="lifespan"
                                      value="{{ old('lifespan', $post->lifespan) }}"
                                      placeholder="{{ __('models/post.lifespan_placeholder') }}"
                                      required/>
                        <x-input-error :messages="$errors->get('lifespan')" class="mt-2"/>
                    </div>
                </div>

                {{-- Image --}}
                <div class="form-group row" id="form-panel-image">
                    <div class="col-lg-12 col-md-12 mb-3">
                        <x-input-label for="image" :value="__('models/post.deceased_image')"></x-input-label>
                        <x-input-info :content="__('models/post.deceased_image_helper_info')" />
                        <input type="file" name="image" id="image">
                        <small id="logo-message" class="text-xs font-weight-bold"></small>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>

                {{-- Symbol --}}
                <div class="form-group row">
                    <div class="col-sm-12">
                        <x-input-label for="symbol" :value="__('models/post.symbol')"/>
                        <x-input-info :content="__('models/post.symbol_info')"/>
                        <select class="form-control border border-dark" id="symbol" name="symbol">
                            @foreach($symbols as $key => $value)
                                <option
                                    value="{{ $key }}" @selected((string)$key === (string)old('symbol', $post->symbol->value))>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Intro message --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="intro_message" :value="__('models/post.intro_message')"/>
                        <textarea id="intro_message" name="intro_message" class="form-control" rows="3"
                                  placeholder="{{ __('models/post.intro_message_placeholders.' . $post->type->value) }}">{{ old('intro_message', $post->intro_message) }}</textarea>
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
                                      value="{{ old('deceased_full_name_sm', $post->deceased_full_name_sm) }}"
                                      placeholder="{{ __('models/post.deceased_full_name_sm_placeholder') }}"/>
                    </div>
                </div>

                {{-- Main message --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="main_message" :value="__('models/post.main_message')"/>
                        <textarea id="main_message" name="main_message" class="form-control" rows="6"
                                  placeholder="{{ __('models/post.main_message_placeholders.' . $post->type->value) }}">{{ old('main_message', $post->main_message) }}</textarea>
                    </div>
                </div>

                {{-- Signature --}}
                <div class="form-group row">
                    <div class="col-12">
                        <x-input-label for="signature" :value="__('models/post.signature')"/>
                        <textarea id="signature" name="signature" class="form-control" rows="3"
                                  placeholder="{{ __('models/post.signature_placeholder') }}">{!! old('signature', $post->signature) !!}</textarea>
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
    @include('partials.filepond.image')
    @push('scripts')
        <script type="module">
            // Elements
            const size = document.getElementById('size');
            const type = document.getElementById('type');
            const type_preview = document.getElementById('type_preview');
            const intro_message = document.getElementById('intro_message');
            const intro_message_preview = document.getElementById('intro_message_preview');
            const main_message = document.getElementById('main_message');
            const main_message_preview = document.getElementById('main_message_preview');
            const deceased_full_name_lg = document.getElementById('deceased_full_name_lg');
            const deceased_full_name_lg_preview = document.getElementById('deceased_full_name_lg_preview');
            const is_framed = document.getElementById('is_framed');
            const image_preview = document.getElementById('image_preview');
            const image = document.getElementById('deceased_image');
            const symbol = document.getElementById('symbol');
            const lifespan = document.getElementById('lifespan');
            const lifespan_preview = document.getElementById('lifespan_preview');
            const deceased_full_name_sm = document.getElementById('deceased_full_name_sm');
            const deceased_full_name_sm_preview = document.getElementById('deceased_full_name_sm_preview');
            const signature = document.getElementById('signature');
            const signature_preview = document.getElementById('signature_preview');
            const post_preview_wrapper = document.getElementById('post-preview-wrapper');

            const intro_msg_placeholders = @json(__('models/post.intro_message_placeholders'), JSON_THROW_ON_ERROR);
            const main_msg_placeholders = @json(__('models/post.main_message_placeholders'), JSON_THROW_ON_ERROR);
            const types = @json($types, JSON_THROW_ON_ERROR);

            document.addEventListener('DOMContentLoaded', function () {
                $('#starts_at').datepicker({
                    dateFormat: "dd.mm.yy.",
                    autoSize: true,
                    language: "hr",
                });
                updateCounter()
                handlePostPreview();
            })

            size.addEventListener('change', updateCounter);

            type.addEventListener('change', function (event) {
                type_preview.textContent = types[event.target.value];
                intro_message.placeholder = intro_msg_placeholders[event.target.value];
                main_message.placeholder = main_msg_placeholders[event.target.value];
            })

            is_framed.addEventListener('change', toggleFrame)

            deceased_full_name_lg.addEventListener('input', function (event) {
                deceased_full_name_lg_preview.innerHTML = event.target.value.replace(/\n/g, "<br>");
            })

            symbol.addEventListener('change', handleSymbolPreview)

            lifespan.addEventListener('input', handleLifespanPreview)

            intro_message.addEventListener('input', function () {
                handleIntroMsgPreview();
                updateCounter();
            })

            deceased_full_name_sm.addEventListener('input', handleDeceasedFullNameSmPreview)

            main_message.addEventListener('input', function () {
                handleMainMsgPreview()
                updateCounter();
            });

            signature.addEventListener('input', handleSignaturePreview);

            /**
             * Count words from element
             *
             * @param textarea
             * @returns int
             */
            function countWords(textarea) {
                return textarea.value.split(' ').filter(function (n) {
                    return n != ''
                }).length;
            }

            /**
             * Update counter labels
             */
            function updateCounter() {
                const word_count = countWords(intro_message) + countWords(main_message);
                const word_count_treshold = parseInt(size.value);

                const counter = document.getElementById('message_counter');

                counter.textContent = `${word_count} / ${word_count_treshold}`;
                counter.classList.toggle('text-counter-danger', word_count > word_count_treshold);
                counter.classList.toggle('text-counter-success', word_count <= word_count_treshold);
            }

            /**
             * Toggle post frame according to checkbox
             */
            function toggleFrame() {
                if (is_framed.checked) {
                    post_preview_wrapper.classList.add('border_special');
                    post_preview_wrapper.classList.remove('border_classic');
                }
                else {
                    post_preview_wrapper.classList.add('border_classic');
                    post_preview_wrapper.classList.remove('border_special');
                }
            }

            /**
             * Handle post preview, element by element
             */
            function handlePostPreview() {
                handleDeceasedFullNameLgPreview();
                handleLifespanPreview()
                handleImagePreview();
                handleSymbolPreview();
                handleIntroMsgPreview();
                handleMainMsgPreview();
                handleSignaturePreview();
                handleDeceasedFullNameSmPreview();
            }

            /**
             * Handle deceased_full_name_lg preview
             */
            function handleDeceasedFullNameLgPreview() {
                deceased_full_name_lg_preview.innerHTML = deceased_full_name_lg.value.trim();
            }

            /**
             * Handle lifespan preview
             */
            function handleLifespanPreview() {
                lifespan_preview.innerHTML = lifespan.value.trim();
            }

            /**
             * Handle image_preview
             */
            function handleImagePreview() {
                const has_image = '{{ $post->image }}'
                const hidden_image_element = document.querySelector('[type="hidden"][name="image"]');

                if (has_image) {
                    image_preview.style.display = 'block';
                    image.src = '{{ public_storage_asset($post->image) }}';
                    return;
                }

                image_preview.style.display = 'none';
                image.src = '';
            }

            /**
             * Update symbol display
             */
            function handleSymbolPreview() {
                if (symbol.value === '') {
                    $('#symbol_wrapper').hide();
                } else {
                    $('#symbol_wrapper').show();
                    $('#symbol_image').attr('src', `${window.location.origin}/graphics/post_symbol/${symbol.value}.svg`)
                }
            }

            /**
             * Handle intro_message preview
             */
            function handleIntroMsgPreview() {
                intro_message_preview.innerHTML = intro_message.value.replace(/\n/g, "<br>");
            }

            /**
             * Handle deceased_full_name_sm preview
             */
            function handleDeceasedFullNameSmPreview() {
                deceased_full_name_sm_preview.innerHTML = deceased_full_name_sm.value.trim();
            }

            /**
             * Handle main_message preview
             */
            function handleMainMsgPreview() {
                main_message_preview.innerHTML = main_message.value.replace(/\n/g, "<br>");
            }

            /**
             * Handle signature preview
             */
            function handleSignaturePreview() {
                signature_preview.innerHTML = signature.value.replace(/\n/g, "<br>");
            }
        </script>
    @endpush

</x-app-layout>
