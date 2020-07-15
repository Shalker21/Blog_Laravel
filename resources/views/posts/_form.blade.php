<div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control"  name="title" value="{{ old('title', $post->title ?? null) }}"/>
</div>

<div class="form-group">
    <label for="content">Content:</label>
    <input type="text" class="form-control" name="content" value="{{ old('content', $post->content ?? null) }}" />
</div>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
