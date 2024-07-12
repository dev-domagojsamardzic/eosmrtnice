@push('scripts')
    <script type="module">

        function changeImageFromPreview() {

            const hidden_image_element = document.querySelector('[type="hidden"][name="image"]');
            const deceased_image = document.getElementById('deceased_image')

            if (hidden_image_element && hidden_image_element.value) {
                image_preview.style.display = 'block';
                deceased_image.src = window.location.origin + '/storage/' + hidden_image_element.value;
                return;
            }

            image_preview.style.display = 'none';
            deceased_image.src = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            FilePond.create(document.querySelector('#image'), {
                labelIdle: '{!! __('filepond.labelIdle') !!}',
                labelInvalidField: '{{ __('filepond.labelInvalidField') }}',
                labelFileWaitingForSize: '{{ __('filepond.labelFileWaitingForSize') }}',
                labelFileSizeNotAvailable: '{{ __('filepond.labelFileSizeNotAvailable') }}',
                labelFileLoading: '{{ __('filepond.labelFileLoading') }}',
                labelFileLoadError: '{{ __('filepond.labelFileLoadError') }}',
                labelFileProcessing: '{{ __('filepond.labelFileProcessing') }}',
                labelFileProcessingComplete: '{{ __('filepond.labelFileProcessingComplete') }}',
                labelFileProcessingAborted: '{{ __('filepond.labelFileProcessingAborted') }}',
                labelFileProcessingError: '{{ __('filepond.labelFileProcessingError') }}',
                labelFileProcessingRevertError: '{{ __('filepond.labelFileProcessingRevertError') }}',
                labelFileRemoveError: '{{ __('filepond.labelFileRemoveError') }}',
                labelTapToCancel: '{{ __('filepond.labelTapToCancel') }}',
                labelTapToRetry: '{{ __('filepond.labelTapToRetry') }}',
                labelTapToUndo: '{{ __('filepond.labelTapToUndo') }}',
                labelButtonRemoveItem: '{{ __('filepond.labelButtonRemoveItem') }}',
                labelButtonAbortItemLoad: '{{ __('filepond.labelButtonAbortItemLoad') }}',
                labelButtonRetryItemLoad: '{{ __('filepond.labelButtonRetryItemLoad') }}',
                labelButtonAbortItemProcessing: '{{ __('filepond.labelButtonAbortItemProcessing') }}',
                labelButtonUndoItemProcessing: '{{ __('filepond.labelButtonUndoItemProcessing') }}',
                labelButtonRetryItemProcessing: '{{ __('filepond.labelButtonRetryItemProcessing') }}',
                labelButtonProcessItem: '{{ __('filepond.labelButtonProcessItem') }}',
                imageValidateSizeMinWidth: {{ config('eosmrtnice.image_dimensions.deceased_image.width') }},
                imageValidateSizeMaxWidth: 2000,
                imageValidateSizeMinHeight: {{ config('eosmrtnice.image_dimensions.deceased_image.height') }},
                imageValidateSizeMaxHeight: 2400,
                imageValidateSizeLabelFormatError: '{{ __('filepond.imageValidateSizeLabelFormatError') }}',
                imageValidateSizeLabelImageSizeTooSmall: '{{ __('filepond.imageValidateSizeLabelImageSizeTooSmall') }}',
                imageValidateSizeLabelImageSizeTooBig: '{{ __('filepond.imageValidateSizeLabelImageSizeTooBig') }}',
                imageValidateSizeLabelExpectedMinSize: '{{ __('filepond.imageValidateSizeLabelExpectedMinSize') }}',
                imageValidateSizeLabelExpectedMaxSize: '{{ __('filepond.imageValidateSizeLabelExpectedMaxSize') }}',
                allowPaste: false,
                checkValidity: true,
                credits: null,
                dropValidation: true,
                acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
                files: [
                    @if(old('image', $post->image))
                    {
                        source: '{{ old('image', $post->image) }}',
                        options: {
                            type: 'local',
                        },
                    }
                    @endif
                ],
                server: {
                    load: (source, load) => {
                        // Override img path with img asset URL
                        source = '{{ public_storage_asset(old('image', $post->image) ?? '') }}';
                        fetch(source)
                            .then(res => res.blob())
                            .then(load);
                    },
                    revert: '{{ route('images.upload.revert') }}',
                    process: {
                        url: '{{ route('images.upload', ['field' => 'image']) }}',
                        method: 'POST',
                        onload: (response) => {
                            response = JSON.parse(response);
                            return response.image;
                        },
                        onerror: (response) => {
                            response = JSON.parse(response);
                            $('#image-message').removeClass(['text-success','text-danger'])
                                .text('')
                                .addClass(response.class)
                                .text(response.message);
                            return response;
                        }
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                },
            });

            document.addEventListener('FilePond:processfile', changeImageFromPreview)
            document.addEventListener('FilePond:removefile', changeImageFromPreview)
        })
    </script>
@endpush
