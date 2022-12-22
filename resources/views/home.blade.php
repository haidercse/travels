<form action="{{ route('home.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Submit</button>
</form>
