import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Button from "../ui/button/Button";
import { useNavigate } from "react-router";
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
import { getGradById } from "../../utils/functions";
interface MajorTableProps {
  setToOpenModalInParentPage: (v: string) => void;
}
function SectionsTable({ setToOpenModalInParentPage }: MajorTableProps) {
  const { sections, setSections } = useTheme();
  const navigate = useNavigate();
  const [toOpenModal, setToOpenModal] = useState<"delete" | "edit" | "">("");
  const [loading, setLoading] = useState(true);
  const { isOpen, openModal, closeModal } = useModal();
  const [toDeleteSectionId, setToDeleteSectionId] = useState<number>(-1);
  const [toUpdateMajorId, setToUpdateMajorId] = useState<number>(-1);
  const { majorId } = useTheme();

  useEffect(() => {
    const fetchSections = async () => {
      try {
        const response = await axiosInstance.get("/sections");
        const sectionsData = response.data as any;
        setSections(sectionsData.data);
      } catch (error) {
        toast.error("Failed to fetch sections  data.");
      } finally {
        setLoading(false);
      }
    };

    fetchSections();
  }, []);

  const handleDelete = async (id: number) => {
    try {
      const response = await axiosInstance.delete(`/sections/${id}`);
      if (response.status === 200) {
        const newSections = sections.filter((s) => s.id !== id);
        setSections(newSections);
        toast.success("Section deleted successfully.");
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
    <div className="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/[0.05] dark:bg-white/[0.03]  max-lg:w-full">
      <div className="max-w-full  max-lg:overflow-x-auto">
        <div className="min-w-[1000px]">
          <Table className=" max-lg:ml-0">
            {/* Table Header */}
            <TableHeader className="border-b border-gray-100 dark:border-white/[0.05]">
              <TableRow>
                {["name", "major", "grad"].map((title, idx) => (
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
                : sections
                    .filter(
                      (item) => item.major.id === majorId || majorId === -1
                    )
                    ?.map((Section) => (
                      <TableRow
                        onClick={() => {
                          navigate(`/supervisor/${Section.id}`);
                        }}
                        key={Section.id}
                        className="hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
                      >
                        <TableCell className="px-3  text-start dark:text-gray-500 ">
                          {Section.name}
                        </TableCell>
                        <TableCell className="px-3  text-start dark:text-gray-500">
                          {Section.major.name}
                        </TableCell>
                        <TableCell className="px-3  text-start dark:text-gray-500">
                          {getGradById(Section.major.grade_id)}
                        </TableCell>

                        <TableCell className="px-5 py-4 flex gap-2">
                          <Button
                            size="sm"
                            variant="outline"
                            onClick={(e) => {
                              e.stopPropagation();
                              setToOpenModalInParentPage("section");
                              setToUpdateMajorId(Section.id);
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
                              setToOpenModalInParentPage("section");
                              setToDeleteSectionId(Section.id);
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
            text="if you delete this section, all related data will be deleted as well."
            okText="Yes, Delete"
            cancelText="No, Cancel"
            okColor="destructive"
            cancelColor="secondary"
            onCancel={closeModal}
            classNameOkButton="bg-red-500 hover:bg-red-400 hover:text-black"
            onOk={() => handleDelete(toDeleteSectionId)}
            confirmationItemId={toDeleteSectionId}
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

export default SectionsTable;
