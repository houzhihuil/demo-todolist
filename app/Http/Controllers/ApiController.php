<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ApiController extends Controller
{
    //
    public function index()
    {
        // Retrieve and return a list of items
        try {
            // Retrieve a list of items from the database
            $items = Item::all();

            // Return the list of items as a JSON response
            return response()->json(['data' => $items], 200);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['error' => 'Failed to retrieve items.'], 500);
        }
    }
    
    public function store(Request $request)
    {
        // Create a new item based on the request data
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                // Add any other validation rules as needed
            ]);
    
            // Create a new item
            $item = Item::create($validatedData);
    
            // Return the created item as a JSON response with a 201 status code (Created)
            return response()->json(['data' => $item], 201);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['error' => 'Failed to create an item.'], 500);
        }
    }
    
    public function show($id)
    {
        // Retrieve and return a specific item by its ID
        try {
            // Find the item by its ID
            $item = Item::findOrFail($id);
    
            // Return the item as a JSON response
            return response()->json(['data' => $item], 200);
        } catch (\Exception $e) {
            // Handle the case where the item with the given ID is not found
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        // Update a specific item by its ID based on the request data
        try {
            // Find the item by its ID
            $item = Item::findOrFail($id);
    
            // Validate and update the item
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                // Add any other validation rules as needed
            ]);
    
            $item->update($validatedData);
    
            // Return the updated item as a JSON response
            return response()->json(['data' => $item], 200);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['error' => 'Failed to update the item.'], 500);
        }
    }
    
    public function destroy($id)
    {
        // Delete a specific item by its ID
        try {
            // Find the item by its ID and delete it
            $item = Item::findOrFail($id);
            $item->delete();
    
            // Return a success message as a JSON response
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['error' => 'Failed to delete the item.'], 500);
        }
    }
    
}
