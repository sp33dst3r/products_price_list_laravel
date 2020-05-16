@extends('layouts.app')

<h2>Фильтр</h2>
<form action="results" method="get">

    <div class="form-group">


        @foreach( $chars as $key => $char )

        <h4 ><?=$key;?></h4>
        <div class="form-check">

            @foreach($char as $k => $char_self)



            <label class="form-check-label" ><?=$char_self?></label>
            <input type="checkbox"
            <?php

                 if(request()->get("chars") && array_key_exists($key, request()->get("chars")) && in_array($char_self, request()->get("chars")[$key]) ){
                   echo "checked";
                }
            ?>
            name="chars[<?=$key?>][]" value="<?=$char_self?>" class="form-check-input" >
            @endforeach
        </div>
        @endforeach
    </div>
    <div class="form-group">
        <label  for="pl">Название</label>
        <input type="text" name="name" value="<?=request("name");?>" class="form-control" id="pl">
    </div>
    <div class="form-group">
        <h3  for="pl">Сортировать по цене</h3>
        <div class="form-check">
            <label for="">По возрастанию</label>
            <input type="radio" name="order" value="asc"
            <?php if(request('order') == 'asc') echo 'checked'; ?>
            />
        </div>
        <div class="form-check">
            <label for="">По убыванию</label>
            <input type="radio" name="order" value="desc"
            <?php if(request('order') == 'desc') echo 'checked'; ?>
            />
        </div>

    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Найти</button>
    </div>
</form>

<h3>Прайслист</h3>

<table class="table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Price</th>
        <th scope="col">Characteristics</th>
      </tr>
    </thead>
    <tbody>
        <?php
            #dd($products);

            ?>
        @forelse ($products as $product)
            <tr>
                <td><?=$product->name?></td>
                <td><?=$product->price?></td>
                <td>
                    @foreach($product->characters as $character)
                        <?php echo $character->name." : ".$character->value; ?> <br />
                    @endforeach
                </td>

          </tr>

        @empty
            <p>No products</p>
        @endforelse


      </tbody>
</table>


