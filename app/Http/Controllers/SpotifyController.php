<?php

namespace App\Http\Controllers;

use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Aerni\Spotify\Facades\SpotifyFacade as SpotifyException;

class SpotifyController extends Controller
{
    public function displayTitles()
    {
    $titles = Test::all(); // Retrieve all titles, including Spotify track IDs

    return view('welcome', compact('titles'));
    }

    public function addTitle(Request $request)
    {
    // Validate the input
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $title = $request->input('title');
    $randomVotes = rand(1, 100);

    try {
        $searchResults = Spotify::searchTracks("track:\"$title\"")->get(); // Use double quotes to search for an exact title match

        if (!isset($searchResults['tracks']) || empty($searchResults['tracks']['items'])) {
            // Song not found on Spotify, return an error
            return redirect()->back()->with('error', 'Song not found on Spotify.');
        }

        // Filter the search results to find the exact title match
        $exactMatch = null;
        foreach ($searchResults['tracks']['items'] as $track) {
            if (strtolower($track['name']) === strtolower($title)) {
                $exactMatch = $track;
                break;
            }
        }

        if ($exactMatch === null) {
            // Exact title match not found, return an error
            return redirect()->back()->with('error', 'Exact title match not found on Spotify.');
        }

        // Create a new title record in the database
        Test::create([
            'title' => $title,
            'votes' => $randomVotes,
            // You can also store additional information from the exact match, if needed
            'spotify_track_id' => $exactMatch['id'],
        ]);

        return redirect()->back()->with('success', 'Title added successfully.');
    } catch (SpotifyException $e) {
        // Handle any exceptions thrown by the Spotify package
        return redirect()->back()->with('error', 'Error communicating with Spotify.');
    }
    }

}
