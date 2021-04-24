<select class="form-control" id="account-select" name="account">
    @foreach ($accounts as $account)
        <option value="{{ $account->id }}">{{ $account->name }}</option>
    @endforeach
</select>
