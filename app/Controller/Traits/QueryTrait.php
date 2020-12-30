<?php


namespace Laztopaz\Controller\Traits;


use PDO;

trait QueryTrait
{
    /**
     * @param null $id
     * @return array
     */
    public function getEvents($id = null): array
    {
        $sql = null === $id
            ? "SELECT 
                      et.id,
                      et.title, 
                      et.description, 
                      et.img_cover, 
                      et.number_of_participants, 
                      et.date_opened, 
                      et.registration_deadline_date,
                      ep.is_premium,
                      ee.event_id,
                      GROUP_CONCAT(ep.type) As types
                       
                FROM event_event_types ee 
                    JOIN events et ON et.id = ee.event_id  
                    JOIN event_types ep ON ep.id=ee.event_type_id  
                GROUP BY ee.event_id, ep.is_premium
                ORDER BY et.registration_deadline_date
            "

            : "SELECT
                      et.id,
                      et.title, 
                      et.description, 
                      et.img_cover, 
                      et.number_of_participants, 
                      et.date_opened, 
                      et.registration_deadline_date, 
                      ep.is_premium,
                      ee.event_id,
                      GROUP_CONCAT(ep.type, '') As types
                FROM event_event_types ee 
                    JOIN events et ON et.id = ee.event_id  
                    JOIN event_types ep ON ep.id=ee.event_type_id  
                    WHERE event_id = :event
                GROUP BY ee.event_id , ep.is_premium
                ORDER BY et.registration_deadline_date";

        $stmt = $this->db->prepare( $sql);

        if (null !== $id) {
            $stmt->bindParam(':event', $id);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    /**
     * @param null $search
     * @return array
     */
    public function getSearchEvents($search = null): array
    {
        $sql = "SELECT 
                      et.id,
                      et.title, 
                      et.description, 
                      et.img_cover, 
                      et.number_of_participants, 
                      et.date_opened, 
                      et.registration_deadline_date,
                      ep.is_premium,
                      GROUP_CONCAT(ep.type) As types
                       
                FROM event_event_types ee 
                    JOIN events et ON et.id = ee.event_id  
                    JOIN event_types ep ON ep.id=ee.event_type_id 
                WHERE et.title LIKE '%{$search}%' 
                   OR et.description LIKE '%{$search}%'
                GROUP BY ee.event_id, ep.is_premium
                ORDER BY et.registration_deadline_date  
            ";

        $stmt = $this->db->prepare( $sql);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

}