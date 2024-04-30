<?php

namespace App\Modules\BusinessDashboard\Employee\Service;

use App\Models\Order;
use App\Models\Organization\Employee\Employee;
use App\Modules\BusinessDashboard\Employee\Dto\CreateEmployeeDto;
use App\Modules\BusinessDashboard\Employee\Dto\GetTimeSlotsDto;
use App\Modules\BusinessDashboard\Employee\Dto\UpdateEmployeeDto;
use Illuminate\Support\Carbon;

class EmployeeService
{
    public function create(CreateEmployeeDto $dto): Employee
    {
        $employee = new Employee();
        $employee->username = $dto->username;
        $employee->password = $dto->password;
        $employee->phone = $dto->phone;
        $employee->email = $dto->email;
        $employee->full_name = $dto->full_name;
        $employee->organization_id = $dto->organization_id;
        $employee->profile_photo = $dto->profile_photo;

        $employee->save();
        return $employee->makeHidden('password');
    }

    public function update(UpdateEmployeeDto $dto): Employee
    {
        $employee = Employee::query()->find($dto->id);

        $employee->username = $dto->username;
        $employee->password = $dto->password;
        $employee->phone = $dto->phone;
        $employee->email = $dto->email;
        $employee->full_name = $dto->full_name;
        $employee->organization_id = $dto->organization_id;
        $employee->profile_photo = $dto->profile_photo;
        $employee->save();
        return $employee->first()->makeHidden('password');
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
    }

    public function getEmployeeTimeSlots(GetTimeSlotsDto $dto)
    {
        $workingHoursStart = 8; // Начало рабочего дня в 8 утра
        $workingHoursEnd = 20; // Конец рабочего дня в 8 вечера
        $selectedDate = $dto->day;
        $serviceDuration = $dto->duration;

        $startDate = Carbon::createFromFormat('Y-m-d H', "{$selectedDate} {$workingHoursStart}");
        $endDate = Carbon::createFromFormat('Y-m-d H', "{$selectedDate} {$workingHoursEnd}");
        $intervalMinutes = 30;

        // Получаем занятые тайм-слоты за выбранный день
        $existingOrders = Order::whereDate('start_time', '=', $selectedDate)
            ->orWhereDate('end_time', '=', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->get(['start_time', 'end_time']);

// Генерация всех возможных тайм-слотов на выбранный день
        $allTimeSlots = collect();
        $currentTime = $startDate->copy()->setHour(8); // Начало рабочего времени, например, в 8:00

        while ($currentTime->lessThan($endDate)) {
            $allTimeSlots->push($currentTime->copy());
            $currentTime = $currentTime->addMinutes($intervalMinutes);
        }

// Фильтрация доступных тайм-слотов
        $availableTimeSlots = $allTimeSlots->filter(function ($slotStart) use ($existingOrders, $serviceDuration, $endDate, $intervalMinutes) {
            // Предполагаемый конец слота
            $slotEnd = $slotStart->copy()->addMinutes($serviceDuration);

            if ($slotEnd->greaterThan($endDate)) {
                return false; // Слот выходит за пределы рабочего дня
            }

            foreach ($existingOrders as $order) {
                $orderStart = new Carbon($order->start_time);
                $orderEnd = new Carbon($order->end_time);

                // Если слот начинается ровно в момент окончания предыдущего заказа, это допустимо
                if (!($slotStart->gte($orderEnd) || $slotEnd->lte($orderStart))) {
                    return false; // Слот пересекается с существующим заказом
                }
            }
            return true;
        })->map(function ($slotStart) {
            // Возвращаем только время начала для каждого доступного тайм-слота
            return $slotStart->format('H:i');
        })->values();

        return $availableTimeSlots;
    }
}
