<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function shouldReturnJson(Request $request): bool
    {
        return $request->wantsJson() || $request->expectsJson();
    }

    protected function paginatedJson(LengthAwarePaginator $paginator, callable $formatter, array $extraMeta = []): JsonResponse
    {
        return response()->json([
            'data' => collect($paginator->items())
                ->map($formatter)
                ->values(),
            'meta' => array_merge([
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ], $extraMeta),
        ]);
    }

    protected function savedResponse(
        Request $request,
        string $routeName,
        string $message,
        array $payload = [],
        int $status = 200
    ): JsonResponse|RedirectResponse {
        if ($this->shouldReturnJson($request)) {
            return response()->json(array_merge([
                'message' => $message,
            ], $payload), $status);
        }

        return redirect()->route($routeName)->with('success', $message);
    }

    protected function backSavedResponse(
        Request $request,
        string $message,
        array $payload = [],
        int $status = 200
    ): JsonResponse|RedirectResponse {
        if ($this->shouldReturnJson($request)) {
            return response()->json(array_merge([
                'message' => $message,
            ], $payload), $status);
        }

        return back()->with('success', $message);
    }

    protected function deletedResponse(Request $request, string $routeName, string $message): JsonResponse|RedirectResponse
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return redirect()->route($routeName)->with('success', $message);
    }

    protected function backDeletedResponse(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
