<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Test extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tracks';

    protected $fillable = [
        'title',
        'votes',
        'spotify_track_id',
    ];

    public function getCoverArt($spotifyTrackId)
    {
        try {
            $track = Spotify::track($spotifyTrackId);

            // Access cover art URL if available
            $coverArtUrl = $track->album->images[0]->url;

            if ($coverArtUrl) {
                return $coverArtUrl;
            }
        } catch (\Exception $e) {
            // Handle any exceptions or return a default cover image URL
        }

        // Return a default cover image URL if no cover art is found
        return 'default_cover_image_url';
    }
}
