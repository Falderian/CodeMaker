<form method="get" action="{{ route('user.index') }}">
  <div class="row mb-3">
    <div class="col-md-3">
      <div class="form-group">
        <label for="group">Group:</label>
        <select class="form-control" name="groups[]" multiple>
          @foreach ($groupOptions as $groupKey => $groupValue)
          <option value="{{ $groupKey }}" {{ in_array($groupKey, $groups) ? 'selected' : '' }}>
            {{ $groupValue }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="status">Status:</label>
        <select class="form-control" name="statuses[]" multiple>
          @foreach ($statusOptions as $statusKey => $statusValue)
          <option value="{{ $statusKey }}" {{ in_array($statusKey, $statuses) ? 'selected' : '' }}>
            {{ $statusValue }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="currency">Currency:</label>
        <select class="form-control" name="currencies[]" multiple>
          @foreach ($currencyOptions as $currency)
          <option value="{{ $currency }}" {{ in_array($currency, $selectedCurrencies) ? 'selected' : '' }}>
            {{ $currency }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="d-flex flex-column">
        <button type="submit" class="btn btn-primary mt-4">Apply Filter</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary mt-4">Reset Filters</a>
      </div>
    </div>
  </div>
</form>
