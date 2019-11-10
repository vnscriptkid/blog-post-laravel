<div class="form-group">
    <label for="postTitle">Title</label>
    <input class="form-control" type="text" name="title" id="postTitle" value="{{ old('title', $post->title ?? null) }}">
</div>
<div class="form-group">
    <label for="postContent">Content</label>
    <textarea class="form-control" name="content" id="postContent" cols="30" rows="5">{{ old('content', $post->content ?? null) }}</textarea>
</div>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
    </div>
    <div class="custom-file">
        <input type="file" name="image" class="custom-file-input" id="postImage" aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" for="postImage">Choose image</label>
    </div>
</div>
<button class="btn btn-block btn-primary" type="submit">Submit</button>
