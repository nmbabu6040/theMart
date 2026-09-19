<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuestion;
use Illuminate\Http\Request;

class ContactQuestionController extends Controller
{
    // List all submitted questions
    public function index()
    {
        $questions = ContactQuestion::latest()->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    // View specific question
    public function show($id)
    {
        $question = ContactQuestion::findOrFail($id);
        $question->update(['is_read' => true]); // Mark as read when viewed

        return view('admin.questions.show', compact('question'));
    }

    // Delete a question
    public function destroy($id)
    {
        ContactQuestion::findOrFail($id)->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
    }
}
