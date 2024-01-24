<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Break_;

class ProductController extends Controller
{
    //
    public function index()
    {
       
       
        $Products = Product::all();

        return view('frontend.product.my-product', ['Products' => $Products]);
        
    }

    public function show($id)
    {
        $product = Product::find($id);
        $brand = Brand::find($product->id_brand);
        $brands = Brand::all();
        $categories = Category::all();

        return view('frontend.product.detail-product', ['product' => $product, 
        'brand' => $brand,
        'brands' => $brands, 
        'categories' => $categories]);
        
    }

    public function create()
    {
       
        $categories = Category::all();
        $brands = Brand::all();

        return view('frontend.product.add-product', ['categories' => $categories, 'brands' => $brands]);
        
    }

    public function store(ProductRequest $request)
    {
        $data = [];
        

        if ($request->hasfile('files')) {
          
            // Loop through each uploaded file
            foreach ($request->file('files') as $image) {
        
                $name = $image->getClientOriginalName();

                // Append timestamp to the original file name
                $timestamp = time();
                $name = $timestamp . '_' . $name;



                $name_2 = "hinh50_" . $name;
                $name_3 = "hinh200_" . $name;

                $user = auth()->user();
                $folderPath = public_path("storage/products/{$user->id}");

                if(!is_dir($folderPath)){
                    mkdir($folderPath);
                }

               
                // Set the paths for the three different images
                $path = public_path("storage/products/{$user->id}/" . $name);
                $path2 = public_path("storage/products/{$user->id}/" . $name_2);
                $path3 = public_path("storage/products/{$user->id}/" . $name_3);

                

        
        
                // Use the Intervention Image library to save and resize the images
                Image::make($image->getRealPath())->save($path);
                Image::make($image->getRealPath())->resize(50, 70)->save($path2);
                Image::make($image->getRealPath())->resize(200, 300)->save($path3);
                

                
                $name =   $user->id. '/'. $name;
                $data[] = $name;
            }
        
            // // Convert the array of file names into a JSON-encoded string
            //     $jsonString = json_encode($data);

            //     // Echo the JSON-encoded result
            //     echo $jsonString;
        }

        
        Product::create([
            'id_user' => $request->input('id_category'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'id_category' => $request->input('id_category'),
            'id_brand' => $request->input('id_brand'),
            'status' => 1,
            'sale' => $request->input('quantity'),
            'company' => $request->input('company'),
            'detail' => $request->input('detail'),
            'images' => json_encode($data),
        ]);
        
        return redirect()->route('product');
    }

    
    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::all();
        $categories = Category::all();

        return view('frontend.product.edit-product', ['product' => $product, 'brands' => $brands, 'categories' => $categories]);
        
    }

    // ProductRequest
    public function update(Request $request ,$id)
    {
        $user = auth()->user();
        $product = Product::find($id);

        $data = $request->all();

        $decodedImages = json_decode($product->images, true);
       
        $updatedImageNames = [];
                
        $totalSelectedImages = 0;
        $totalNotSelectedImages = 3;
        
        $totalFiles = 0;
       

        if ($request->has('selected_images')) {
            // Get the array of selected image 
            $selectedImages = $request->input('selected_images');
            $totalSelectedImages = count($selectedImages);
        } else {
            $totalSelectedImages = 0;
        }

        if ($request->hasfile('files')) {
            // Get the array of uploaded files
            $files = $request->file('files');
            // Check the total number of files
            $totalFiles = count($files);
        } else {
            $totalFiles = 0;
        }

        $totalNotSelectedImages -= $totalSelectedImages;

        // echo '$totalSelectedImages :   ' . $totalSelectedImages;
        // echo '$totalFiles :   ' . $totalFiles;

        // Check if the total selected images and total files exceed the limit
        if ($totalNotSelectedImages + $totalFiles > 3  ) {
            // Return an error response or handle it as needed
            return back()->with('error', 'Tổng số ảnh update không hợp lệ');
        }


        if ($totalSelectedImages == 0 && $totalFiles > 0) {
            // Return an error response or handle it as needed
            return back()->with('error', 'Please select to delete images before update');
        }


        // xử lý xoá hình ảnh trong folder product
        if ($request->has('selected_images')) {

            // lấy array of selected image 
            $selectedImages = $request->input('selected_images');

            // lấy tổng số ảnh đã chọn
            $totalselectedImages = count($selectedImages);

            // lấy ra value index của những hình ảnh không được chọn
            $notSelectedValues = array_diff(array_keys($decodedImages), $selectedImages);
           
            // tên của những hình ảnh không được tick chọn sẽ được đưa vào mảng $updatedImageNames
            foreach ($notSelectedValues as $index) {
                $notSelectedImage =  $decodedImages[$index];
                $updatedImageNames[$index] = $notSelectedImage;
            }
            

            // những hình ảnh được chọn sẽ được xử lý xoá khỏi thư mục ảnh products
            foreach ($selectedImages as $index) {
               
                $name = $decodedImages[$index];

                $name_2 = "hinh50_" . $name;
                $name_3 = "hinh200_" . $name;

                $file1 = public_path("storage/products/{$user->id}/{$name}");
                $file2 = public_path("storage/products/{$user->id}/{$name_2}");
                $file3 = public_path("storage/products/{$user->id}/{$name_3}");

                try {
                    // Check if the file exists before attempting to delete
                    if (File::exists($file1)) {
                        File::delete($file1);
                    }
        
                    if (File::exists($file2)) {
                        File::delete($file2);
                    }
        
                    if (File::exists($file3)) {
                        File::delete($file3);
                    }
                } catch (\Exception $e) {
                    // Handle the exception, log it, or display a user-friendly error message
                    return back()->with('error', 'An error occurred while deleting files.');
                }
    
             
            }


            // xử lý upload file ảnh mới
            if ($request->hasfile('files')) {
          
                // lặp qua từng file ảnh được up load
                foreach ($request->file('files') as $image) {
            
                    $name = $image->getClientOriginalName();

                    // Append timestamp to the original file name
                    $timestamp = time();
                    $name = $timestamp . '_' . $name;
       
                    
                    $i = 0;
                  

                    

                 
                    $name_2 = "hinh50_" . $name;
                    $name_3 = "hinh200_" . $name;
    
                    $user = auth()->user();
                    $folderPath = public_path("storage/products/{$user->id}");
    
                    if(!is_dir($folderPath)){
                        mkdir($folderPath);
                    }
    
                   
                    // Set the paths for the three different images
                    $path = public_path("storage/products/{$user->id}/" . $name);
                    $path2 = public_path("storage/products/{$user->id}/" . $name_2);
                    $path3 = public_path("storage/products/{$user->id}/" . $name_3);
                    

                    for ($x = $i; $x <= 10; $x++) {

                        $index = $selectedImages[$x];

                        // Add the file name to the updatedImageNames array

                        $name =   $user->id. '/'. $name;

                        $updatedImageNames[$index] = $name;
                        $i++;
                        break;
                    }
            
                    // Use the Intervention Image library to save and resize the images
                    Image::make($image->getRealPath())->save($path);
                    Image::make($image->getRealPath())->resize(50, 70)->save($path2);
                    Image::make($image->getRealPath())->resize(200, 300)->save($path3);
            
                  
                }
            
            }

           // Echo or print the values in $updatedImageNames
            // foreach ($updatedImageNames as $index => $imageName) {
            //     echo "Index: $index, Image Name: $imageName <br>";
            // }
    
        }

        // update product
        $product                = Product::find($id);
        $product->name   = $data['name'];
        $product->price         = $data['price'];
        $product->id_category   = $data['id_category'];
        $product->id_brand    = $data['id_brand'];
        $product->status         = 1;
        $product->sale    = $data['quantity'];
        $product->company    = $data['company'];
        $product->detail    = $data['detail'];
        $product->images    = $request->hasfile('files') ? json_encode($updatedImageNames) : $decodedImages;


        if( $product->save() ) {
            return back()->with('success', 'Updated product successfully');
        }else{
            return back()->with('error', 'Error when update product');
        }
        

      

      
        
    }

    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        
        return redirect()->route('product');
    }
}
