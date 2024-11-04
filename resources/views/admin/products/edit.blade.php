@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0 my-2">Product Edit</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form method="post" class="" action="{{ route('products.update', $product->id) }}">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ $errors->first() }}</strong>
                                        </div>
                                    @endif
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input class="form-control my-2" name="name" value="{{ $product->name }}"
                                                    required autocomplete="given-name">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="product_image">Product Image</label>
                                                <br>
                                                @if ($product->product_image)
                                                    <img src="{{ asset('Image/' . $product->product_image) }}"
                                                        width="100" height="100" alt="Product Image">
                                                @endif

                                                @error('product_image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Description:</strong>
                                                <input class="form-control my-2" type="text" name="description"
                                                    value="{{ $product->description }}" required autocomplete="description">
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <strong>Image:</strong>
                                                <input type="file" class="form-control" name="product_image"
                                                    id="product_image" value="{{ $product->product_image }}">
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Price:</strong>
                                                <input class="form-control my-2" type="number" name="price"
                                                    value="{{ $product->price }}" required autocomplete="price">
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Quantity:</strong>
                                                <input class="form-control my-2" type="number" name="quantity"
                                                    value="{{ $product->quantity }}" required autocomplete="quantity">
                                                @error('quantity')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Category:</strong>
                                                <select name="category_id" id="category" class="form-control my-2"
                                                    required>
                                                    <option value="">Select category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if ($category->id == $selectedCatryId) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Tags:</strong>
                                                <select name="tag_ids[]" id="tags" class="js-example-basic-multiple form-control"
                                                multiple="multiple">
                                                    <option value="">Select tag</option>
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->id }}"
                                                            @if (in_array($tag->id, $selectedTagIds)) selected @endif>
                                                            {{ $tag->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tag_ids')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class=" my-4 text-end">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                            <a href="{{ route('products.index') }}" class="btn btn-danger">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
