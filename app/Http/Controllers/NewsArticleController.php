<?php

namespace App\Http\Controllers;

use App\News;
use App\WriterProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\File;
use Carbon\Carbon;

class NewsArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$articles = News::published();

		// Create and Resize the default image
		Image::make(public_path('images/emptyface.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
        return view('news.index', compact('articles', 'defaultImg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$writer = Auth::user()->writer;
		$totalArticles = $writer->post->count();
		$publishedArticles = $writer->post()->published()->count();
		
        return view('news.create', compact('totalArticles', 'publishedArticles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$writer = Auth::user()->writer;
		
        $news = new News();
		$news->writer_id = $writer->id;
		$news->title = $request->title;
		$news->article = $request->article;
		$news->publish = $request->publish;
		$news->publish_date = $request->publish == 'Y' ?  Carbon::now() : null;
		
		if($request->hasFile('picture')) {
			$newImage = $request->file('picture');
			// Check to see if upload is an image
			if($newImage->guessExtension() == 'jpeg' || $newImage->guessExtension() == 'png' || $newImage->guessExtension() == 'gif' || $newImage->guessExtension() == 'webp' || $newImage->guessExtension() == 'jpg') {
				
				// Check to see if images is too large
				if($newImage->getError() == 1) {
					$fileName = $request->file('picture')[0]->getClientOriginalName();
					$error .= "<li class='errorItem'>The picture " . $fileName . " is too large and could not be uploaded</li>";
				} elseif($newImage->getError() == 0) {
					// Check to see if images is about 25MB
					// If it is then resize it
					if($newImage->getClientSize() < 25000000) {
						$image = Image::make($newImage->getRealPath())->orientate();
						$path = $newImage->store('public/images');
						$news->picture = $path;
						
						if($image->save(storage_path('app/'. $path))) {
							// prevent possible upsizing
							// Create a larger version of the image
							// and save to large image folder
							$image->resize(1700, null, function ($constraint) {
								$constraint->aspectRatio();
								// $constraint->upsize();
							});
							
							
							if($image->save(storage_path('app/'. str_ireplace('images', 'images/lg', $path)))) {								
								// Create a smaller version of the image
								// and save to large image folder
								$image->resize(544, null, function ($constraint) {
									$constraint->aspectRatio();
								});
								
								if($image->save(storage_path('app/'. str_ireplace('images', 'images/sm', $path)))) {}
							}
						}
					} else {
						// Resize the image before storing. Will need to hash the filename first
						$image = Image::make($newImage)->orientate()->resize(1500, null, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						});
						
						$path = $newImage->store('public/images');
					}
				} else {
					$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
				}
			} else {
				$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
			}
		}

			
		if($news->save()) {
			return redirect()->route('writers.show', ['writer' => $news->writer->id])->with('status', 'New Article Added Successfully');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
		$article = $news;
		$recentPost = $news->writer->post()->recentPost($article->id);
		
		// Create and Resize the default image
		Image::make(public_path('images/emptyface.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
        return view('news.show', compact('article', 'defaultImg', 'recentPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $article = $news;
		$recentPost = $news->writer->post()->recentPost($article->id);
		
		// Create and Resize the default image
		Image::make(public_path('images/emptyface.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
        return view('news.edit', compact('article', 'defaultImg', 'recentPost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
		$news->title = $request->title;
		$news->article = $request->article;
		$news->publish = $request->publish;
		$news->publish_date = $request->publish == 'Y' ?  Carbon::now() : null;
		
		if($request->hasFile('picture')) {
			$newImage = $request->file('picture');
			// Check to see if upload is an image
			if($newImage->guessExtension() == 'jpeg' || $newImage->guessExtension() == 'png' || $newImage->guessExtension() == 'gif' || $newImage->guessExtension() == 'webp' || $newImage->guessExtension() == 'jpg') {
				
				// Check to see if images is too large
				if($newImage->getError() == 1) {
					$fileName = $request->file('picture')[0]->getClientOriginalName();
					$error .= "<li class='errorItem'>The picture " . $fileName . " is too large and could not be uploaded</li>";
				} elseif($newImage->getError() == 0) {
					// Check to see if images is about 25MB
					// If it is then resize it
					if($newImage->getClientSize() < 25000000) {
						$image = Image::make($newImage->getRealPath())->orientate();
						$path = $newImage->store('public/images');
						$news->picture = $path;
						
						if($image->save(storage_path('app/'. $path))) {
							// prevent possible upsizing
							// Create a larger version of the image
							// and save to large image folder
							$image->resize(1700, null, function ($constraint) {
								$constraint->aspectRatio();
								// $constraint->upsize();
							});
							
							
							if($image->save(storage_path('app/'. str_ireplace('images', 'images/lg', $path)))) {								
								// Create a smaller version of the image
								// and save to large image folder
								$image->resize(544, null, function ($constraint) {
									$constraint->aspectRatio();
								});
								
								if($image->save(storage_path('app/'. str_ireplace('images', 'images/sm', $path)))) {}
							}
						}
					} else {
						// Resize the image before storing. Will need to hash the filename first
						$image = Image::make($newImage)->orientate()->resize(1500, null, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						});
						
						$path = $newImage->store('public/images');
					}
				} else {
					$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
				}
			} else {
				$error .= "<li class='errorItem'>The file " . $fileName . " may be corrupt and could not be uploaded</li>";
			}
		}

			
		if($news->save()) {
			return redirect()->action('WriterProfileController@show', ['writer' => $news->writer->id])->with('status', 'Article Updated Successfully');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        if($news->delete()) {
			return redirect()->route('writers.show', ['writer' => $news->writer->id])->with('status', 'Article Deleted Successfully');
		}
    }

	/**
     * Search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
		$articles = News::search(str_ireplace(' ', '', str_ireplace('_', '', $request->search)));
		$searchCriteria = $request->search;
		
		// Create and Resize the default image
		Image::make(public_path('images/commissioner.jpg'))->resize(350, null, 	function ($constraint) {
				$constraint->aspectRatio();
			}
		)->save(storage_path('app/public/images/lg/default_img.jpg'));
		$defaultImg = asset('/storage/images/lg/default_img.jpg');
		
		return view('news.index', compact('searchCriteria', 'defaultImg', 'articles'));
    }
}
