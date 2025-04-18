import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Button from "../ui/button/Button";

import { User } from "../../utils/types";
import { useEffect, useState } from "react";
import axiosInstance from "../../utils/Interceptor";
import { useTheme } from "../../context/ThemeContext";
import { toast } from "react-toastify";
import { Modal } from "../ui/modal";
import { useModal } from "../../hooks/useModal";
import DefaultModal from "../ui/modal/DefaultModal";
import ConfirmationModal from "../ui/modal/ConfirmationModal";
import AddEmployeeModal from "../ui/modal/AddEmployeeModal";
import { formatCustomDate } from "../../utils/functions";

export default function EmployeeTable() {
  const [toOpenModal, setToOpenModal] = useState<"delete" | "edit" | "">("");
  const [loading, setLoading] = useState(true); // ✅ loading state
  const { isOpen, openModal, closeModal } = useModal();
  const { employees, setEmployees, toDeleteOrUpdateEmployeeId, setToDeleteOrUpdateEmployeeId } = useTheme();

  useEffect(() => {
    const fetchEmployeesData = async () => {
      try {
        const response = await axiosInstance.get("/employees");
        const data = (response.data as { data: User[] }).data;
        setEmployees(data);
      } catch (error) {
        toast.error("Failed to fetch employees data.");
      } finally {
        setLoading(false); // ✅ stop loading
      }
    };

    fetchEmployeesData();
  }, []);

  const handleDelete = async (id: number) => {
    try {
      const response = await axiosInstance.delete(`/employees/${id}`);
      if (response.status === 200) {
        const updatedEmployees = employees.filter((user) => user.id !== id);
        setEmployees(updatedEmployees);
        toast.success("Employee deleted successfully.");
      }
    } catch (error: any) {
      if (error.response) {
        const errorMessage = error.response.data.message;
        toast.error(errorMessage);
      } else {
        toast.error("An error occurred. Please try again.");
      }
    } finally {
      closeModal();
    }
  };

  return (
    <div className="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/[0.05] dark:bg-white/[0.03]">
      <div className="max-w-full overflow-x-auto">
        <div className="min-w-[1000px]">
          <Table>
            {/* Table Header */}
            <TableHeader className="border-b border-gray-100 dark:border-white/[0.05]">
              <TableRow>
                {["Username", "Email", "First Name", "Last Name", "Role", "Created At", "Updated At", "Actions"].map((title, idx) => (
                  <TableCell
                    key={idx}
                    isHeader
                    className="px-5 py-3 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400"
                  >
                    {title}
                  </TableCell>
                ))}
              </TableRow>
            </TableHeader>

            {/* Table Body */}
            <TableBody className="divide-y divide-gray-100 dark:divide-white/[0.05]">
              {loading
                ? Array.from({ length: 5 }).map((_, index) => (
                    <TableRow key={index}>
                      {Array.from({ length: 8 }).map((__, i) => (
                        <TableCell key={i} className="px-5 py-4">
                          <div className="h-4 bg-gray-300 dark:bg-gray-600 rounded animate-pulse w-3/4"></div>
                        </TableCell>
                      ))}
                    </TableRow>
                  ))
                : employees.map((user) => (
                    <TableRow key={user.id}>
                      <TableCell className="px-5 py-4 text-start dark:text-gray-500">
                        {user.username}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start dark:text-gray-500">
                        {user.email}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start dark:text-gray-500">
                        {user.first_name}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start dark:text-gray-500">
                        {user.last_name}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start capitalize dark:text-gray-500">
                        {user.role}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start capitalize dark:text-gray-500">
                        {formatCustomDate(user.created_at)}
                      </TableCell>
                      <TableCell className="px-5 py-4 text-start capitalize dark:text-gray-500">
                        {formatCustomDate(user.updated_at)}
                      </TableCell>
                      <TableCell className="px-5 py-4 flex gap-2">
                        <Button
                          size="sm"
                          variant="outline"
                          onClick={() => {
                            setToDeleteOrUpdateEmployeeId(user.id);
                            setToOpenModal("edit");
                            openModal();
                          }}
                        >
                          Update
                        </Button>
                        <Button
                          size="sm"
                          onClick={() => {
                            setToDeleteOrUpdateEmployeeId(user.id);
                            setToOpenModal("delete");
                            openModal();
                          }}
                        >
                          Delete
                        </Button>
                      </TableCell>
                    </TableRow>
                  ))}
            </TableBody>
          </Table>
        </div>
      </div>

      {/* Modal */}
      <Modal isOpen={isOpen} onClose={closeModal} className="max-w-[700px] m-4">
        {toOpenModal === "delete" ? (
          <ConfirmationModal
            text="Are you sure you want to delete this Admin?"
            okText="Yes, Delete"
            cancelText="No, Cancel"
            okColor="destructive"
            cancelColor="secondary"
            onCancel={closeModal}
            classNameOkButton="bg-red-500 hover:bg-red-400 hover:text-black"
            onOk={() => handleDelete(toDeleteOrUpdateEmployeeId)}
          />
        ) : (
          <AddEmployeeModal closeModal1={closeModal} action="edit" />
        )}
      </Modal>
    </div>
  );
}
