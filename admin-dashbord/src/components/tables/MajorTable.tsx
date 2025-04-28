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
import AddMajorModal from "../ui/modal/AddMajorModal";
interface MajorTableProps {
  setToOpenModalInParentPage: (v: string) => void;
}
function MajorTable({ setToOpenModalInParentPage }: MajorTableProps) {
  const { gradId } = useTheme();
  const navigate = useNavigate();
  const [toOpenModal, setToOpenModal] = useState<"delete" | "edit" | "">("");
  const [loading, setLoading] = useState(true);
  const { isOpen, openModal, closeModal } = useModal();
  const [toDeleteMajorId, setToDeleteMajorId] = useState<number>(-1);
  const [toUpdateMajorId, setToUpdateMajorId] = useState<number>(-1);
  const { supervisors, setSupervisors, majors, setMajors } = useTheme();

  useEffect(() => {
    const fetchMajors = async () => {
      try {
        const response = await axiosInstance.get("/majors");
        const majorsData = response.data as any;
        setMajors(majorsData.data);
      } catch (error) {
        toast.error("Failed to fetch majors  data.");
      } finally {
        setLoading(false);
      }
    };

    fetchMajors();
  }, []);

  const handleDelete = async (id: number) => {
    try {
      const response = await axiosInstance.delete(`/majors/${id}`);
      if (response.status === 200) {
        const newMajors = majors.filter((major) => major.id !== id);
        setMajors(newMajors);
        toast.success("major deleted successfully.");
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
  const filteredMajors =
    gradId === -1
      ? majors
      : majors.filter((major) => major.grade.id === gradId);
  return (
    <div className="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/[0.05] dark:bg-white/[0.03]  max-lg:w-full">
      <div className="max-w-full  max-lg:overflow-x-auto">
        <div className="min-w-[1000px]">
          <Table className=" max-lg:ml-0">
            {/* Table Header */}
            <TableHeader className="border-b border-gray-100 dark:border-white/[0.05]">
              <TableRow>
                {["name", "grad"].map((title, idx) => (
                  <TableCell
                    key={idx}
                    isHeader
                    className="py-3 px-2 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400"
                  >
                    {title}
                  </TableCell>
                ))}
              </TableRow>
            </TableHeader>

            {/* Table Body */}
            <TableBody className="divide-y divide-gray-100 dark:divide-white/[0.05]">
              {loading
                ? Array.from({ length: 10 }).map((_, index) => (
                    <TableRow key={index}>
                      {Array.from({ length: 8 }).map((__, i) => (
                        <TableCell key={i} className="px-5 py-4">
                          <div className="h-4 bg-gray-300 dark:bg-gray-600 rounded animate-pulse w-3/4"></div>
                        </TableCell>
                      ))}
                    </TableRow>
                  ))
                : filteredMajors?.map((major) => (
                    <TableRow
                      onClick={() => {
                        navigate(`/supervisor/${major.id}`);
                      }}
                      key={major.id}
                      className="hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
                    >
                      <TableCell className="px-3  text-start dark:text-gray-500 ">
                        {major.name}
                      </TableCell>
                      <TableCell className="px-3  text-start dark:text-gray-500">
                        {major.grade.name}
                      </TableCell>

                      <TableCell className="px-5 py-4 flex gap-2">
                        <Button
                          size="sm"
                          variant="outline"
                          onClick={(e) => {
                            e.stopPropagation();
                            setToOpenModalInParentPage("major");
                            setToUpdateMajorId(major.id);
                            setToOpenModal("edit");
                            openModal();
                          }}
                        >
                          Update
                        </Button>
                        <Button
                          size="sm"
                          onClick={(e) => {
                            e.stopPropagation();
                            setToOpenModalInParentPage("major");
                            setToDeleteMajorId(major.id);
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
            text="if you delete this major, all related data will be deleted as well."
            okText="Yes, Delete"
            cancelText="No, Cancel"
            okColor="destructive"
            cancelColor="secondary"
            onCancel={closeModal}
            classNameOkButton="bg-red-500 hover:bg-red-400 hover:text-black"
            onOk={() => handleDelete(toDeleteMajorId)}
            confirmationItemId={toDeleteMajorId}
          />
        ) : (
          <AddMajorModal
            closeModal1={closeModal}
            action="edit"
            confirmationItemId={toUpdateMajorId}
          />
        )}
      </Modal>
    </div>
  );
}

export default MajorTable;
