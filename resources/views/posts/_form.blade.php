<div class="form-group">
    <label for="postTitle">Title</label>
    <input class="form-control" type="text" name="title" id="postTitle" value="{{ old('title', $post->title ?? null) }}">
</div>
<div class="form-group">
    <label for="postContent">Content</label>
    <textarea class="form-control" name="content" id="postContent" cols="30" rows="5">{{ old('content', $post->content ?? null) }}</textarea>
</div>
<button class="btn btn-block btn-primary" type="submit">Submit</button>
