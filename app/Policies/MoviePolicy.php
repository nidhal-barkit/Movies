<?php

namespace App\Policies;

use App\User;
use App\Movie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the movie.
     *
     * @param  \App\User  $user
     * @param  \App\Movie  $movie
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->getRole()=='Admin') {

            return true;
        }
    }

    public function view(User $user, Movie $movie)
    {
        return true;
    }

    /**
     * Determine whether the user can create movies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the movie.
     *
     * @param  \App\User  $user
     * @param  \App\Movie  $movie
     * @return mixed
     */

    public function edit(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }

    public function update(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }

    /**
     * Determine whether the user can delete the movie.
     *
     * @param  \App\User  $user
     * @param  \App\Movie  $movie
     * @return mixed
     */
    public function delete(User $user, Movie $movie)
    {

        return $user->id === $movie->user_id;
    }

    /**
     * Determine whether the user can restore the movie.
     *
     * @param  \App\User  $user
     * @param  \App\Movie  $movie
     * @return mixed
     */
    public function restore(User $user, Movie $movie)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the movie.
     *
     * @param  \App\User  $user
     * @param  \App\Movie  $movie
     * @return mixed
     */
    public function forceDelete(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }
}
