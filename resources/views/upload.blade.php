@extends('layouts.app')
<form action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="form-check-label" for="pl">Файл с прайслистом</label>
      <input type="file" name="data" class="form-control" id="pl">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </div>
  </form>
