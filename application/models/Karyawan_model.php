<?php

class Karyawan_model extends CI_Model {
    public function getKaryawan($emp_no = null) {

        if ($emp_no === null) {
            $this->db->select('employees.*, MAX(salaries.salary) AS salary, departments.dept_name, titles.title ');
            $this->db->from('employees');
            $this->db->join('salaries', 'employees.emp_no = salaries.emp_no', 'left');
            $this->db->join('dept_emp', 'employees.emp_no = dept_emp.emp_no', 'left');
            $this->db->join('titles', 'employees.emp_no = titles.emp_no', 'left');
            $this->db->join('departments', 'dept_emp.dept_no = departments.dept_no', 'left');
            $this->db->group_by('employees.emp_no');
            $this->db->limit(1000);

            return $this->db->get()->result_array();
        } else {
            $this->db->select('employees.*, MAX(salaries.salary) AS salary, departments.dept_name, titles.title ');
            $this->db->from('employees');
            $this->db->where('employees.emp_no', $emp_no);
            $this->db->join('salaries', 'employees.emp_no = salaries.emp_no', 'left');
            $this->db->join('dept_emp', 'employees.emp_no = dept_emp.emp_no', 'left');
            $this->db->join('titles', 'employees.emp_no = titles.emp_no', 'left');
            $this->db->join('departments', 'dept_emp.dept_no = departments.dept_no', 'left');
            $this->db->group_by('employees.emp_no');
            $this->db->limit(1000);

            return $this->db->get()->result_array();
        }
    }

    public function deleteKaryawan($emp_no) {
        $this->db->delete('employees', ['emp_no' => $emp_no]);
        return $this->db->affected_rows();
    }

    public function createKaryawan($data) {
        $this->db->insert('employees', $data);
        return $this->db->affected_rows();
    }

    public function updateKaryawan($data, $emp_no) {
        $this->db->update('employees', $data, ['emp_no' => $emp_no]);
        return $this->db->affected_rows();
    }
}