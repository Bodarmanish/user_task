<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Validator;

class taskController extends Controller
{
    public function allTask(Request $request){
        try {
            $user = auth()->user();
            $task = Task::where('user_id',$user->id)->get();
            if(count($task) > 0){
                return $this->sendResponse($task, 'Your All Task');
            } else {
                return $this->sendError(null,'Task not found!');
            }
        }
        catch(NotFoundHttpException $exception) {
            return $this->sendError('Unauthorised.','Credentials not match!');
        }
    }

    public function getTask($id){
        try {
            $task = Task::where('id',$id)->first();
            if($task){
                return $this->sendResponse($task, 'Task Details');
            } else {
                return $this->sendError(null,'Task not found!');
            }
        }
        catch(NotFoundHttpException $exception) {
            return $this->sendError('Unauthorised.','Credentials not match!');
        }
    }

    public function addTask(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            $errorMessages = implode(',', $validator->errors()->all());
            return $this->sendError('error', $errorMessages);
        }

        $user = auth()->user();
        $task = Task::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return $this->sendResponse($task, 'your task details added successfully!');
        
    }

    public function updateTask(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            $errorMessages = implode(',', $validator->errors()->all());
            return $this->sendError('error', $errorMessages);
        }

        $task = Task::where('id',$id)->first();
        if($task){
            $user = auth()->user();
            $task->update([
                'user_id' => $user->id,
                'name' => $request->name,
                'description' => $request->description,
                'completion_status' => $request->status,
            ]);
            return $this->sendResponse($task, 'your task details Updated successfully!');
        } else {
            return $this->sendError(null,'Task not found!');
        }
    }

    public function removeTask($id){
        $task = Task::where('id',$id)->first();
        if($task){
            $task->delete();
            return $this->sendResponse(null, 'your task details Remove successfully!');
        } else {
            return $this->sendError(null,'Task not found!');
        }
    }
}
