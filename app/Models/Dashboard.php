<?php
namespace App\Models;

use App\Core\Model;

class Dashboard extends Model
{
    public function getTotalReaders()
    {
        $sql = "SELECT COUNT(*) as total FROM readers";
        $result = $this->select($sql, [], true);
        return $result['total'] ?? 0;
    }

    public function getTotalCategories()
    {
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->select($sql, [], true);
        return $result['total'] ?? 0;
    }

    public function getTotalBooks()
    {
        $sql = "SELECT COUNT(*) as total FROM books";
        $result = $this->select($sql, [], true);
        return $result['total'] ?? 0;
    }

    public function getTotalBorrowedBooks()
    {   
        $sql = "SELECT SUM(bsd.quantity) as total
                FROM borrow_slip_details bsd
                INNER JOIN borrow_slips bs ON bsd.borrow_slip_id = bs.id
                WHERE bs.status = 'borrowing' OR bs.status IS NULL";
        $result = $this->select($sql, [], true);
        return $result['total'] ?? 0;
    }

    public function getTop10Readers()
    {
        $sql = "SELECT name, phone, bookcount FROM readers ORDER BY bookcount DESC LIMIT 10";
        return $this->select($sql);
    }

    public function getTop10Books()
    {
        $sql = "SELECT b.title, SUM(bsd.quantity) as total_borrowed
                FROM borrow_slip_details bsd
                JOIN books b ON bsd.book_id = b.id
                GROUP BY b.id, b.title
                ORDER BY total_borrowed DESC
                LIMIT 10";
        return $this->select($sql);
    }
} 