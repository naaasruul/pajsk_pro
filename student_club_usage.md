# Example Usage: Student and Club Relationship in Laravel

## Attach a Student to a Club

To assign a student to a club with a specific position:

```php
<?php
$student = Student::find(1);
$club = Club::find(1);
$student->clubs()->attach($club->id, ['club_position_id' => 2]); // Position ID 2
```

---

## Detach a Student from a Club

To remove a student from a club:

```php
<?php
$student->clubs()->detach($club->id);
```

---

## Retrieve Students in a Club

To get all students in a specific club:

```php
<?php
$club = Club::find(1);
$students = $club->students;
```

---

## Retrieve Clubs for a Student

To get all clubs a specific student has joined:

```php
<?php
$student = Student::find(1);
$clubs = $student->clubs;
```