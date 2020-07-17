<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\StoreRequest;
use App\Http\Requests\Games\UpdateRequest;
use App\Models\Games\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class handling the CRUD operation of Game Model
 *
 * Class GameController
 * @package App\Http\Controllers\Admin
 */
class GameController extends Controller
{

    /**
     * Display a listing of the Games
     *
     * @return View    index page listing all the games paginated
     */
    public function index()
    {
        $games = Game::paginate(15);

        return view('admin.games.index', ['games' => $games]);
    }

    /**
     * Show the form for creating a new Game
     *
     * @return View view with the create form for Game
     */
    public function create()
    {
        return view('admin.games.create');
    }

    /**
     * Show the form for editing the Game
     *
     * @param Game $game         Game that will be edited
     * @return View              view with edition form
     */
    public function edit(Game $game)
    {

        return view('admin.games.edit', ['game' => $game]);
    }

    /**
     * Store a newly created Game in database.
     *
     * @param StoreRequest $request          request with data from creation form
     * @return RedirectResponse         redirect to index page
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreRequest $request)
    {

        Game::create($request->all());
        flash()->success('Game successfully created');

        return redirect()->route('game.index');

    }

    /**
     * Update the chosen Game in database.
     *
     * @param UpdateRequest $request   request containing all the data from the edition form
     * @param Game $game         Game to be edited
     * @return RedirectResponse  return index view of games
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Game $game, UpdateRequest $request)
    {
        $game->update($request->all());
        flash()->success('Game successfully updated');

        return redirect()->route('game.index');
    }

    /**
     * Remove the chosen Game in database.
     *
     * @param Game $game         Game to be deleted
     * @return RedirectResponse  return index view of games
     */
    public function destroy(Game $game)
    {
        try {
            $game->delete();
            flash()->success('Game successfully deleted');

        } catch (\Exception $ex) {
            flash()->error('Game deletion was unsuccessful');

        }

        return redirect()->route('game.index');

    }
}
