import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Button from "../ui/button/Button";
import { useNavigate } from "react-router";
import { supervisorArrayResponse } from "../../utils/types";
import { useEffect, useState } from "react";
import axiosInstance from "../../utils/Interceptor";
import { useTheme } from "../../context/ThemeContext";
import { toast } from "react-toastify";
import { Modal } from "../ui/modal";
import { useModal } from "../../hooks/useModal";

import ConfirmationModal from "../ui/modal/ConfirmationModal";
// import AddEmployeeModal from "../ui/modal/AddEmployeeModal";
// import { formatCustomDate } from "../../utils/functions";
import AddSupervisorModal from "../ui/modal/AddSupervisorModal";

function SupervisorsTable() {
  const navigate = useNavigate();
  const [toOpenModal, setToOpenModal] = useState<"delete" | "edit" | "">("");
  const [loading, setLoading] = useState(true);
  const { isOpen, openModal, closeModal } = useModal();

  const {
    toDeleteOrUpdateEmployeeId,
    setToDeleteOrUpdateEmployeeId,
    supervisors,
    setSupervisors,
  } = useTheme();

  useEffect(() => {
    const fetchSupervisors = async () => {
      try {
        const response = await axiosInstance.get("/supervisor");
        const supervisors = response.data as supervisorArrayResponse;
        setSupervisors(supervisors.data);
      } catch (error) {
        toast.error("Failed to fetch employees data.");
      } finally {
        setLoading(false);
      }
    };

    fetchSupervisors();
  }, []);

  const handleDelete = async (id: number) => {
    try {
      const response = await axiosInstance.delete(`/supervisor/${id}`);
      if (response.status === 200) {
        const updatedEmployees = supervisors.filter((user) => user.id !== id);
        setSupervisors(updatedEmployees);
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
                {[
                  "Username",
                  "Email",
                  "First Name",
                  "Last Name",
                  "Actions",
                ].map((title, idx) => (
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
                : supervisors.map((user) => (
                    <TableRow
                      onClick={() => {
                        navigate(`/supervisor/${user.id}`);
                      }}
                      key={user.id}
                      className="hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
                    >
                      <TableCell className="px-5 py-4 text-start dark:text-gray-500 ">
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

                      <TableCell className="px-5 py-4 flex gap-2">
                        <Button
                          size="sm"
                          variant="outline"
                          onClick={(e) => {
                            e.stopPropagation(); // Prevents triggering row click
                            setToDeleteOrUpdateEmployeeId(user.id);
                            setToOpenModal("edit");
                            openModal();
                          }}
                        >
                          Update
                        </Button>
                        <Button
                          size="sm"
                          onClick={(e) => {
                            e.stopPropagation(); // Prevents triggering row click
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
            text="Are you sure you want to delete this supervisor?"
            okText="Yes, Delete"
            cancelText="No, Cancel"
            okColor="destructive"
            cancelColor="secondary"
            onCancel={closeModal}
            classNameOkButton="bg-red-500 hover:bg-red-400 hover:text-black"
            onOk={() => handleDelete(toDeleteOrUpdateEmployeeId)}
          />
        ) : (
          <AddSupervisorModal closeModal1={closeModal} action="edit" />
        )}
      </Modal>
    </div>
  );
}

export default SupervisorsTable;
