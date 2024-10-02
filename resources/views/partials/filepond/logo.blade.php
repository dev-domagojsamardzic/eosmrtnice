@push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.create(document.querySelector('#logo'), {
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
                imageValidateSizeMinWidth: 200,
                imageValidateSizeMaxWidth: 1200,
                imageValidateSizeMinHeight: 200,
                imageValidateSizeMaxHeight: 1200,
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
                    @if(old('logo', $company->logo))
                    {
                        source: '{{ old('logo', $company->logo) }}',
                        options: {
                            type: 'local',
                        },
                    }
                    @endif
                ],
                server: {
                    load: (source, load) => {
                        // Override img path with img asset URL
                        source = '{{ public_storage_asset(old('logo', $company->logo) ?? '') }}';
                        fetch(source)
                            .then(res => res.blob())
                            .then(load);
                    },
                    revert: '{{ route('images.upload.revert') }}',
                    process: {
                        url: '{{ route('images.upload', ['field' => 'logo']) }}',
                        method: 'POST',
                        onload: (response) => {
                            response = JSON.parse(response);
                            return response.image;
                        },
                        onerror: (response) => {
                            response = JSON.parse(response);
                            $('#logo-message').removeClass(['text-success','text-danger'])
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
        })
    </script>
@endpush
