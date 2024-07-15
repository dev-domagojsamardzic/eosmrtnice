<form id="postSearchForm" method="GET">
    <div class="form-group ads-search row">
        <div class="col-sm-12 col-md-4 mb-3">
            <x-input-label for="name" :value="__('models/post.full_name')"/>
            <x-text-input
                id="name"
                type="text"
                name="name"/>
        </div>
        <div class="col-sm-12 col-md-4 mb-3">
            <x-input-label for="date" :value="__('models/post.starts_at')"></x-input-label>
            <div class="input-group input-group-joined date">
                <input name="date"
                       id="date"
                       type="text"
                       class="form-control">
                <span class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </span>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mt-auto mb-3">
            <button id="submitPostSearch" type="submit" class="btn btn-primary">
                <i class="fas fa-search mr-2"></i>
                {{ __('common.search') }}
            </button>
            <a type="button" href="{{ route('homepage') }}" class="btn btn-link">
                {{ __('common.cancel') }}
            </a>
        </div>
    </div>
</form>

