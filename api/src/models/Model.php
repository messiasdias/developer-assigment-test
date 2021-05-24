<?php
namespace App\Models;
use Illuminate\Database\Capsule\Manager as EloquentManager;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public static function paginated(int $page = null, int $perPage = null) : array
    {
      $persons = [];
      if ($page && $perPage) {
        $persons = self::all()
        ->sortByDesc('updated_at')
        ->forPage($page, $perPage)
        ->all();
      }

      if (!$page && !$perPage) {
        $persons = self::all();
      }

      $count = self::all()->count();
      $data = [
        'items' => [],
        'hasNext' => false,
        'total' => $count
      ];

      if ($persons) {
        $data['items'] = $persons;

        if ($page && $perPage) {
          $data = array_merge (
            $data,
            [
              'hasNext' => $count > ($page * $perPage),
              'page' => $page,
              'perPage' => $perPage
            ]
          );
        }
      }

      return $data;
    }
}